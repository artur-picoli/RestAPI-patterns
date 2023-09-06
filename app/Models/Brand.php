<?php

namespace App\Models;

use App\Filters\Traits\Filterable;
use App\Models\Car;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Brand extends Model
{
    use HasFactory, Filterable, HasUlids;

    protected $fillable = [
        'name',
    ];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function sales() : HasManyThrough
    {
        return $this->hasManyThrough(Sale::class, Car::class);
    }
}
