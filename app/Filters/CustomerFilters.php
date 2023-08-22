<?php
namespace App\Filters;

use App\Filters\Base\QueryFilters;
use App\Http\Requests\Api\Customer\IndexRequest;

class CustomerFilters extends QueryFilters
{
    protected $request;
    public function __construct(IndexRequest $request)
    {
        $this->request = $request;
        parent::__construct($request->validated());
    }

    public function name($filter) {
        return $this->builder->where('name', 'LIKE', "%$filter%");
    }

    public function cpf($filter) {
        $cpf = preg_replace('/[^0-9]/', '', $filter);
        return $this->builder->where('cpf', 'LIKE', "%$cpf%");
    }
}

