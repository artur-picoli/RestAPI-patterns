<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'via' => $this->via,
            'cep' => strpos($this->cep, '-') !== true ? substr_replace($this->cep, '-', 5, -3) : $this->cep,
            'logradouro' =>  $this->logradouro ?? $this->street,
            'bairro' => $this->bairro ?? $this->neighborhood,
            'cidade' => $this->localidade ?? $this->city,
            'uf' => $this->uf ?? $this->state,
        ];
    }
}
