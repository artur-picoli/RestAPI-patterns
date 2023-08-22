<?php

namespace App\Models;

use App\Filters\Traits\Filterable;
use App\Models\Sale;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'cpf'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d-m-Y H:i:s');
    }

    protected function cpf(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9),
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value)
        );
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
