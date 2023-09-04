<?php

declare(strict_types=1);

namespace App\Service\CepService;

use App\Contracts\Service\PostalCodeServiceInterface;
use Illuminate\Support\Facades\Http;


class BrasilApiService implements PostalCodeServiceInterface
{

    private string $baseUrl = "https://brasilapi.com.br/api/cep/v1/";

    public function findAddress(string $cep): object
    {
        $response =  Http::get($this->baseUrl . $cep);

        $response = $response->object();

        $response->via = 'brasil-api';

        return $response;
    }

    public function testApi() : bool
    {
        $response =  Http::get($this->baseUrl . "18990156");

        return $response->status() == 200 ?? false;

    }
}
