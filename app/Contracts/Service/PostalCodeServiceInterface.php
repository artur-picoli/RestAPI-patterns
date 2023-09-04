<?php

declare(strict_types=1);

namespace App\Contracts\Service;


interface PostalCodeServiceInterface
{
    public function findAddress(string $cep): object;

    public function testApi() : bool;
}
