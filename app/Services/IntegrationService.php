<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Repositories\Contracts\IntegrationRepositoryInterface;
use stdClass;

class IntegrationService {
    public function __construct(
        protected IntegrationRepositoryInterface $repository,
    ) {
    }

    public function new(CreateCaptureDTO $dto): stdClass {
        return $this->repository->new($dto);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }
}
