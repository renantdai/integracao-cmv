<?php

namespace App\DTO;

use App\Enums\SituacaoRegistro;
use App\Http\Requests\StoreDirectoryRequest;

class CreateDirectoryDTO {
    const RECEBIDO = 1;
    const SENT = 2;
    const ERROR = 3;

    public function __construct(
        public string $id,
        public string $cameras_id,
        public string $tipo_conexao_id,
        public string $diretorio,
        public string $host,
        public string $login,
        public string $password,
        public string $porta,
        public string $situacao_registro_id,
        public string $usuario_criacao,
    ) {
    }

    public static function makeFromRequest(StoreDirectoryRequest $request): self {

        return new self(
            isset($request->id) ? $request->id : '',
            $request->cameras_id,
            $request->tipo_conexao_id,
            $request->diretorio,
            $request->host,
            $request->login,
            $request->password,
            $request->porta,
            isset($request->situacao_registro_id) ? SituacaoRegistro::fromValue($request->situacao_registro_id) : SituacaoRegistro::A,
            1
        );
    }
}
