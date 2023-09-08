<?php
namespace App\Filters;

use App\Filters\Base\QueryFilters;
use App\Http\Requests\Api\Brand\IndexRequest;

class BrandFilters extends QueryFilters
{
    public function __construct(IndexRequest $request)
    {
        parent::__construct($request->validated());
    }

    public function name($filter) {
        return $this->builder->where('name', 'LIKE', "%$filter%");
    }
}

