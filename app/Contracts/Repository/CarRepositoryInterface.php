<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Contracts\Repository\Base\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Filters\CarFilters;


interface CarRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     * @throws ModelNotFoundException
     */
    public function findAll(CarFilters $filters): LengthAwarePaginator;
}
