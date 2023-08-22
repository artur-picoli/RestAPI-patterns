<?php

namespace App\Filters\Base;

use Illuminate\Database\Eloquent\Builder;

class QueryFilters
{
    protected $requestFilters;
    protected $builder;

    public function __construct(array $request)
    {
        $this->requestFilters = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->requestFilters as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            }
        }

        return $this->builder;
    }
}
