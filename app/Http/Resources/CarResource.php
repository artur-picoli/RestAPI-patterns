<?php

namespace App\Http\Resources;

use App\Http\Resources\BrandResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'model' => $this->model,
            'year' => $this->year,
            'color' => $this->color,
            'brand' => new BrandResource($this->whenLoaded('brand'))
        ];
    }
}
