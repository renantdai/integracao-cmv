<?php

namespace App\Repositories;

use App\DTO\CreateCaptureDTO;
use App\Models\Capture;
use App\Models\SituacaoEnvio;
use App\Repositories\Contracts\IntegrationRepositoryInterface;

use stdClass;

class IntegrationEloquentORM implements IntegrationRepositoryInterface {
    public function __construct(
        protected Capture $model
    ) {
    }

    public function new(CreateCaptureDTO $dto): stdClass {
        $capture = $this->model->create(
            (array) $dto
        );

        return (object) $capture->toArray();
    }

    public function validateStatus(CreateCaptureDTO $dto): bool {
        $plate = '';
        if ($dto->cameras_id) {
            $plate = $this->model->select('placa')
                ->where([
                    ['cameras_id', '=', $dto->cameras_id],
                    ['situacao_envio_id', '=', SituacaoEnvio::ENVIADO]
                ])->orderBy('id', 'desc')->first();
        } else {
            $plate = $this->model->select('placa')
                ->where([
                    ['cameras_id', '=', $dto->cameras_id],
                    ['situacao_envio_id', '=', SituacaoEnvio::ENVIADO]
                ])->orderBy('id', 'desc')->first();
        }

        if (empty($plate)) {
            return true;
        }

        return ($plate->placa != $dto->placa) ? true : false;
    }

    public function findOne(string $plate): stdClass|null {
        $capture = $this->model->where('plate', '=', $plate)->orderBy('id', 'desc')->first();
        if (!$capture) {
            return null;
        }

        return (object) $capture->toArray();
    }

    public function alterStatusCapture(CreateCaptureDTO $dto, $status): bool {
        return ($this->model->where('id', $dto->id)->update(['situacao_envio_id' => $status]));
    }

    public function lastSendCam(string $idCam): string | null {
        $plate = $this->model->select('placa')
            ->where([
                ['cameras_id', '=', $idCam],
                ['situacao_envio_id', '=', SituacaoEnvio::RECEBIDO]
            ])->orderBy('id', 'desc')->first();

        if (empty($plate)) {
            return '';
        }

        return $plate->plate;
    }
}
