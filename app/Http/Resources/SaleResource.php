<?php

namespace App\Http\Resources;

use App\Http\Resources\CarResource;
use App\Http\Resources\CustomerResource;
use Carbon\Carbon;
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
            'sold_in' => Carbon::make($this->created_at)->format('d-m-Y H:i:s'),
            'car' => new CarResource($this->whenLoaded('car')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
