<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Contracts\Repository\Base\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Filters\SaleFilters;


interface SaleRepositoryInterface extends BaseRepositoryInterface
{

     /**
     * @return LengthAwarePaginator
     * @throws ModelNotFoundException
     */
    public function findAll(SaleFilters $filters): LengthAwarePaginator;
}
