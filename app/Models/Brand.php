<?php

namespace App\Models;

use App\Filters\Traits\Filterable;
use App\Models\Car;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Brand extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function sales() : HasManyThrough
    {
        return $this->hasManyThrough(Sale::class, Car::class);
    }
}
