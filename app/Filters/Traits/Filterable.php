<?php

namespace App\Filters\Traits;

use App\Filters\Base\QueryFilters;
use Illuminate\Database\Eloquent\Builder;


trait Filterable
{
    public function scopeFilter(Builder $builder, QueryFilters $filters)
    {
        return $filters->apply($builder);
    }
}
