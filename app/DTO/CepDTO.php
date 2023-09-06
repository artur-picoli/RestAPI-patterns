<?php

declare(strict_types=1);

namespace App\DTO;

use App\DTO\Traits\StaticCreateSelf;

class CepDTO
{
    use StaticCreateSelf;

    public string $cep = '';
    public string $logradouro = '';
    public string $bairro = '';
    public string $cidade = '';
    public string $uf = '';
}
