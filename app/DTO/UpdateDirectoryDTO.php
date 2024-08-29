<?php

namespace App\DTO;

use App\Enums\CamStatus;
use App\Http\Requests\StoreCamRequest;


class UpdateDirectoryDTO {

    public function __construct(
        public string $id,
        public string $subject,
        public CamStatus $status,
        public string $body,
    ) {
    }

    public static function makeFromRequest(StoreCamRequest $request, $id = null): self {

        return new self(
            $id ?? $request->id,
            $request->subject,
            CamStatus::A,
            $request->body
        );
    }
}
