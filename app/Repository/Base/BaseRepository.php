<?php

declare(strict_types=1);

namespace App\Repository\Base;

use App\Contracts\Repository\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository implements BaseRepositoryInterface
{

    public function __construct(protected readonly Model $model)
    {
    }

    public function findById(string $id): Model
    {
        return $this->model->query()
            ->findOrFail($id);
    }

    public function deleteById(string $id): bool
    {
        $model = $this->findById($id);

        return $model->delete();
    }
}
