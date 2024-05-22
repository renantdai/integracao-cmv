<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\DTO\CreateCamDTO;
use App\Http\Requests\StoreCamRequest;
use App\Models\Cam;
use App\Repositories\Contracts\CamRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use stdClass;

class CamService {
    public function __construct(
        protected CamRepositoryInterface $repository,
    ) {
    }

    public function paginate(
        int $page = 1,
        int $totalPerPage = 15,
        string $filter = null
    ) {

        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function findOne(string $id): stdClass|null {
        return $this->repository->findOne($id);
    }

    public function new(CreateCamDTO $dto): stdClass {
        return $this->repository->new($dto);
    }

    public function sendPrepare($id, CreateCamDTO $dto) {
        $dtoNew = $dto;
        $dtoNew->id = $id;

        return $this->sendCam($dtoNew);
    }

    public function sendCam(CreateCamDTO $dto): array {
        $envioLeituraService = new ManutencaoEquipamentoService($dto);
        $envioLeituraService->setXmlPostString();

        try {
            $response = $envioLeituraService->sendRecord();
        } catch (Exception $e) {
            Log::info('Erro na requisicao', [
                'cStat' => isset($response->oneResultMsg->retOneRecepLeitura->cStat) ?? 0,
                'msgError' => $e->getMessage()
            ]);

            return $this->validaRetornoEnvioLeituraService(false, $dto);
        }

        return $this->validaRetornoEnvioLeituraService($response, $dto);
    }

    private function validaRetornoEnvioLeituraService($retorno, CreateCamDTO $dto): array {
        $response = ['error' => false];
        if ($retorno == false) {
            //criar log para erros;
            $response = ['error' => true, 'msg' => 'Não houve retorno'];
        }
        if (isset($retorno->body->div[1]->div->fieldset->h2[0])) {
            $erro = $retorno->body->div[1]->div->fieldset->h2[0] . '-' . $retorno->body->div[1]->div->fieldset->h3[0];
            Log::info('Erro SOAP', ['curl' =>  $erro]);
            $response = ['error' => true, 'msg' => $erro];
        }

        $data = isset($retorno->oneResultMsg->retOneManEQP) ? (array) $retorno->oneResultMsg->retOneManEQP : $retorno;
        if (isset($data['cStat'])) { #Testar retorno
            if ($data['cStat'] != 107) {
                Log::info('Erro SOAP', ['curl' =>  'erro 107']);
                $response = ['error' => true, 'msg' => $data['xMotivo'], 'cStat' => $data['cStat']];
            }
        }

        if ($response['error']) {
            $this->repository->alterStatusCam($dto, $dto::ERROR);

            return $response;
        }

        $this->repository->alterStatusCam($dto, $dto::SENT);

        if ($data === 'OK') {
            return ['error' => false, 'msg' => 'OK'];
        }

        return ['error' => false, 'msg' => $data['xMotivo'], 'cStat' => $data['cStat']];
    }

    public function send(string $id) {
        $cam = Cam::find($id);
        if (!$cam) {
            return ['error' => true, 'msg' => 'nao existe esse id'];
        }

        $validateDto = new StoreCamRequest($cam->toArray());

        $dto = CreateCamDTO::makeFromRequest($validateDto);

        return $this->sendCam($dto);
    }
}
