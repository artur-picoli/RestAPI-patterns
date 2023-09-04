<?php

namespace App\Models;

use App\Filters\Traits\Filterable;
use App\Models\Car;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'car_id',
        'customer_id',
        'price'
    ];

    protected $with = [
        'customer'
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => number_format(($value / 100), 2, ',', '.'),
            set: fn (string $value) => $value * 100,
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
