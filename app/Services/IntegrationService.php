<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Repositories\Contracts\IntegrationRepositoryInterface;
use App\Services\EnvioLeituraService;
use Illuminate\Support\Facades\Log;
use Exception;
use stdClass;

class IntegrationService {
    public function __construct(
        protected IntegrationRepositoryInterface $repository,
    ) {
    }

    public function new(CreateCaptureDTO $dto): stdClass {
        $this->saveImage($dto);
        return $this->repository->new($dto);
    }

    public function validateStatus(CreateCaptureDTO $dto): bool {
        if (!$dto->image) {
            return false;
        }
        if ($dto->statusSend == CreateCaptureDTO::RECEBIDO) {

            return $this->repository->validateStatus($dto);
        }

        return true;
    }

    public function findOne(string $id): stdClass|null {
        return $this->repository->findOne($id);
    }

    public function envioLeituraService(CreateCaptureDTO $dto): bool {
        Log::info('Cheguei no envio', ['id' => '1']);
        $envioLeituraService = new EnvioLeituraService($dto);
        Log::info('Passei do objeto', ['id' => '1']);
        $envioLeituraService->setXmlPostString();
        try {
            Log::info('entrei no try', ['id' => '1']);
            $response = $envioLeituraService->sendRecord();
        } catch (Exception $e) {
            Log::info('entrei no cat', ['id' => $e->getMessage()]);
            Log::info('Erro na requisicao', [
                'cStat' => $response->oneResultMsg->retOneRecepLeitura->cStat
            ]);
        }


        return $this->validaRetornoEnvioLeituraService($response, $dto);
    }

    private function validaRetornoEnvioLeituraService($retorno, CreateCaptureDTO $dto): bool {
        if ($retorno == false) {
            //criar log para erros;
            $this->repository->alterStatusCapture($dto, $dto::ERROR);

            return false;
        }

        $data = (array) $retorno->oneResultMsg->retOneRecepLeitura;
        if ($data['cStat'] != 103) {
            //criar log para erros;
            $this->repository->alterStatusCapture($dto, $dto::ERROR);

            return false;
        }
        $this->repository->alterStatusCapture($dto, $dto::SENT);

        return true;
    }

    private function saveImage(CreateCaptureDTO $dto) {
        $imageData = base64_decode($dto->image);
        $source = imagecreatefromstring($imageData);
        $file = 'images/' . $dto->fileName;
        $imageSave = imagejpeg($source, $file, 100); //validar quando true or false
        imagedestroy($source);
    }
}
