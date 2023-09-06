<?php

declare(strict_types=1);

namespace App\Contracts\Repository\Base;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param string $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findById(string $id): Model;

    /**
     * @param string $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteById(string $id): bool;

    /**
     * @param array $data
     * @return Model
     * @throws ModelNotFoundException
     */
    public function create(array $data): Model;

    /**
     * @param string $id
     * @param array $data
     * @return Model
     * @throws ModelNotFoundException
     */

    public function update(string $id, array $data): Model;
}
