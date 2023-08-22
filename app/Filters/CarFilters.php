<?php
namespace App\Filters;

use App\Filters\Base\QueryFilters;
use App\Http\Requests\Api\Car\IndexRequest;

class CarFilters extends QueryFilters
{
    protected $request;
    public function __construct(IndexRequest $request)
    {
        $this->request = $request;
        parent::__construct($request->validated());
    }

    public function model($filter) {
        return $this->builder->where('model', 'LIKE', "%$filter%");
    }

    public function start_year($filter) {
        return $this->builder->where('year','>=', $filter);
    }

    public function finish_year($filter) {
        return $this->builder->where('year','<=', $filter);
    }

    public function color($filter) {
        return $this->builder->where('color','LIKE',"%$filter%");
    }

    public function brand_id($filter) {
        return $this->builder->where('brand_id', $filter);
    }
}

