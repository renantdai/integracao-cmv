<?php

namespace App\Repositories;

use App\DTO\CreateCamDTO;
use App\DTO\UpdateCamDTO;
use App\Models\Cam;
use App\Repositories\Contracts\CamRepositoryInterface;

use stdClass;

class CamEloquentORM implements CamRepositoryInterface {
    public function __construct(
        protected Cam $model
    ) {
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null) {
        $result =  $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('tpMan', $filter);
                }
            })
            ->paginate($totalPerPage, ["*"], 'page', $page);

        return new PaginationPresenter($result);
    }

    public function getAll(string $filter = null): array {
        return [];
    }

    public function findOne(string $id): stdClass |null {
        $cam =  $this->model->find($id);
        if (!$cam) {
            return null;
        }

        return (object) $cam->toArray();
    }

    public function delete(string $id): void {
    }

    public function new(CreateCamDTO $dto): stdClass {
        $cam =  $this->model->create(
            (array) $dto
        );

        return (object) $cam->toArray();
    }

    public function update(UpdateCamDTO $dto): stdClass | null {
        if (!$cam = $this->model->find($dto->id)) {
            return null;
        }

        $cam->update(
            (array) $dto
        );

        return (object) $cam->toArray();
    }

    public function alterStatusCam(CreateCamDTO $dto, $status) {
        return ($this->model->where('id', $dto->id)->update(['statusSend' => $status]));
    }
}
