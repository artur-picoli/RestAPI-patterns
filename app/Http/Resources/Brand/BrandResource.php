<?php

namespace App\Http\Resources\Brand;

use App\Http\Resources\Car\CarResource;
use App\Http\Resources\Sale\SaleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'name' => $this->name,
            'cars_count'=> $this->whenHas('cars_count'),
            'sales_count' => $this->whenHas('sales_count'),
            'cars' => CarResource::collection($this->whenLoaded('cars')),
            'sales' => SaleResource::collection($this->whenLoaded('sales'))
        ];
    }
}
