<?php

namespace App\Repositories;

use App\DTO\CreateCaptureDTO;
use App\Models\Capture;
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

    public function findOne(string $place): stdClass|null {
        $capture = $this->model->where('place', '=', $place)->orderBy('id', 'desc')->first();
        if (!$capture) {
            return null;
        }

        return (object) $capture->toArray();
    }
}
