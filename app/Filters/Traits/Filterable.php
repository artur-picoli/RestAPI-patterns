<?php

namespace App\Filters\Traits;

use App\Filters\Base\QueryFilters;


trait Filterable
{
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
