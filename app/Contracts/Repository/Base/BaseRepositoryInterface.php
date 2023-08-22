<?php

declare(strict_types=1);

namespace App\Contracts\Repository\Base;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Model;

    /**
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteById(int $id): bool;

    /**
     * @param array $data
     * @return Model
     * @throws ModelNotFoundException
     */
    public function create(array $data): Model;

    /**
     * @param int $id
     * @param array $data
     * @return Model
     * @throws ModelNotFoundException
     */

    public function update(int $id, array $data): Model;
}
