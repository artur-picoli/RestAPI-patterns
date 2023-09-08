<?php

namespace App\Filters;

use App\Filters\Base\QueryFilters;
use App\Http\Requests\Api\Sale\IndexRequest;

class SaleFilters extends QueryFilters
{
    public function __construct(IndexRequest $request)
    {
        parent::__construct($request->validated());
    }

    public function customer_id($filter)
    {
        return $this->builder->where('customer_id', $filter);
    }

    public function car_id($filter)
    {
        return $this->builder->where('car_id', $filter);
    }

    public function start_price($filter)
    {
        return $this->builder->where('price', '>=', $filter * 100);
    }

    public function finish_price($filter)
    {
        return $this->builder->where('price', '<=', $filter * 100);
    }

    public function brand_id($filter)
    {
        return $this->builder->whereRelation('car', 'brand_id', $filter);
    }
}
