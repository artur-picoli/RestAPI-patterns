<?php

declare(strict_types=1);

namespace App\Service\CepService;

use App\Contracts\Service\PostalCodeServiceInterface;
use Illuminate\Support\Facades\Http;


class ViaCepService implements PostalCodeServiceInterface
{

    private string $baseUrl = "https://viacep.com.br/ws/";

    public function findAddress(string $cep): object
    {
        $response =  Http::get($this->baseUrl . $cep . "/json/");

        $response = $response->object();

        $response->via = 'via-cep';

        return $response;
    }

    public function testApi() : bool
    {
        $response =  Http::get($this->baseUrl . "18990156/json/");

        return $response->status() == 200 ?? false;
    }
}
