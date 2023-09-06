<?php

namespace App\Models;

use App\Filters\Traits\Filterable;
use App\Models\Brand;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory, Filterable, HasUlids;

    protected $fillable = [
        'model',
        'year',
        'color',
        'brand_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sales() : HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
