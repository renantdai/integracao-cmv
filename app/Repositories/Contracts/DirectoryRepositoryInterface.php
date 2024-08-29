<?php

namespace App\Repositories\Contracts;

use App\DTO\CreateDirectoryDTO;
use App\DTO\UpdateDirectoryDTO;
use stdClass;

interface DirectoryRepositoryInterface {
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null);
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateDirectoryDTO $dto): stdClass;
    public function update(UpdateDirectoryDTO $dto): stdClass | null;
    public function alterStatusCam(CreateDirectoryDTO $id, $status);
}
