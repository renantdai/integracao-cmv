<?php

namespace App\DTO;

use App\Enums\CamStatus;
use App\Http\Requests\StoreCamRequest;

class CreateDirectoryDTO {
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
        public string $statusSend
    ) {
    }

    public static function makeFromRequest(StoreCamRequest $request): self {

        return new self(
            isset($request->id) ? $request->id : '',
            $request->tpAmb,
            $request->verAplic,
            CamStatus::C,
            $request->dhReg,
            $request->CNPJOper,
            $request->cEQP,
            $request->xEQP,
            $request->cUF,
            $request->tpSentido,
            $request->latitude,
            $request->longitude,
            $request->tpEQP,
            $request->xRefCompl,
            self::RECEBIDO
        );
    }
}
