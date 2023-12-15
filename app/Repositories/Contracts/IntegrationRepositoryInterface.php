<?php

namespace App\Repositories\Contracts;

use App\DTO\{
    CreateCaptureDTO
};
use stdClass;

interface IntegrationRepositoryInterface {
    public function new(CreateCaptureDTO $dto): stdClass;
    public function findOne(string $id): stdClass|null;
}
