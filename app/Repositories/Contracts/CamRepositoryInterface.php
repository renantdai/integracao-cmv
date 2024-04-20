<?php

namespace App\Repositories\Contracts;

use App\DTO\CreateCamDTO;
use App\DTO\UpdateCamDTO;
use stdClass;

interface CamRepositoryInterface {
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null);
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateCamDTO $dto): stdClass;
    public function update(UpdateCamDTO $dto): stdClass | null;
    public function alterStatusCam(CreateCamDTO $id, $status);
}
