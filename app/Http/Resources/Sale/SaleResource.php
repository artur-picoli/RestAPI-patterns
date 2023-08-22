<?php

namespace App\Http\Resources\Sale;

use App\Http\Resources\Car\CarResource;
use App\Http\Resources\Customer\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'car' => new CarResource($this->whenLoaded('car')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
