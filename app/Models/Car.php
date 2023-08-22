<?php

namespace App\Models;

use App\Filters\Traits\Filterable;
use App\Models\Brand;
use App\Models\Sale;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'model',
        'year',
        'color',
        'brand_id',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sales() : HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
