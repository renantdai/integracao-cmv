<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Repositories\Contracts\IntegrationRepositoryInterface;
use App\Services\EnvioLeituraService;
use stdClass;

class IntegrationService {
    public function __construct(
        protected IntegrationRepositoryInterface $repository,
    ) {
    }

    public function new(CreateCaptureDTO $dto): stdClass {
        return $this->repository->new($dto);
    }

    public function validateStatus(CreateCaptureDTO $dto): bool {
        if ($dto->statusSend == CreateCaptureDTO::RECEBIDO) {

            return $this->repository->validateStatus($dto);
        }

        return true;
    }

    public function findOne(string $id): stdClass|null {
        return $this->repository->findOne($id);
    }

    public function envioLeituraService(CreateCaptureDTO $dto): bool {
        $envioLeituraService = new EnvioLeituraService($dto);
        $envioLeituraService->setXmlPostString();
        $response = $envioLeituraService->sendRecord();

        return $this->validaRetornoEnvioLeituraService($response, $dto);
    }

    private function validaRetornoEnvioLeituraService($retorno, CreateCaptureDTO $dto): bool {
        $data = (array) $retorno->oneResultMsg->retOneRecepLeitura;
        if ($data['cStat'] != 103) {
            //criar log para erros;
            $this->repository->alterStatusCapture($dto, $dto::ERROR);

            return false;
        }
        $this->repository->alterStatusCapture($dto, $dto::SENT);

        return true;
    }
}
