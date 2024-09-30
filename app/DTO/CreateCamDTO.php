<?php

namespace App\DTO;

use App\Enums\CamStatus;
use App\Enums\TipoSentidoCamera;
use App\Http\Requests\StoreCamRequest;

class CreateCamDTO extends AbstractDTO {
    const RECEBIDO = 1;
    const SENT = 2;
    const ERROR = 3;

    public function __construct(
        public string $id,
        public string $tpAmb,
        public string $verAplic,
        public CamStatus $tpMan,
        public string $dhReg,
        public string $CNPJOper,
        public string $cEQP,
        public string $xEQP,
        public string $cUF,
        public string $tpSentido,
        public string $latitude,
        public string $longitude,
        public string $tpEQP,
        public string $xRefCompl,
        public string $statusSend,
        public string $equipament,
        public string $idRegister,
        //adicionar equipamento gateway
    ) {
    }

    public static function makeFromRequest(StoreCamRequest $request): self {

        return new self(
            isset($request->id) ? $request->id : '',
            $request->tpAmb,
            $request->verAplic,
            isset($request->tpMan) ? CamStatus::getKey($request->tpMan) : CamStatus::C,
            $request->dhReg,
            $request->CNPJOper,
            $request->cEQP,
            $request->xEQP,
            $request->cUF,
            TipoSentidoCamera::sendFromString($request->tpSentido),
            $request->latitude,
            $request->longitude,
            $request->tpEQP,
            $request->xRefCompl,
            self::RECEBIDO,
            1,
            1
        );
    }

    public static function makeFromSave(CreateCamDTO $request): array {
        return [
            'id_registro_camera' => $request->idRegister,
            'tipo_ambiente_id' => $request->tpAmb,
            'tipo_manutencao_id' => $request->tpMan->sendFromValue($request->tpMan->name),
            'equipamentos_id' => $request->equipament,
            'versao_aplicacao' => $request->verAplic,
            'data_registro' => $request->dhReg,
            'identificador_equipamento' => $request->cEQP,
            'nome_amigavel' => $request->xEQP,
            'uf_estado' => $request->cUF,
            'sentido_id' => TipoSentidoCamera::sendFromSave($request->tpSentido),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tipo_equipamento_id' => $request->tpEQP,
            'referencia_complementar' => $request->xRefCompl,
            'situacao_envio_id' => $request->statusSend,
            'situacao_registro_id' => 1,
            'usuario_criacao_id' => 1,
            'usuario_alteracao_id' => 1,
            'cnpj' => $request->CNPJOper
        ];
    }
}
