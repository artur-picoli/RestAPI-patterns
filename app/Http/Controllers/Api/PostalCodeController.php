<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Service\PostalCodeServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\customer\PostalCodeRequest;
use App\Http\Resources\CepResource;
use Exception;
use Illuminate\Support\Facades\Cache;

class PostalCodeController extends Controller
{
    public function __construct(private readonly PostalCodeServiceInterface $service)
    {
    }

    public function findAddress(PostalCodeRequest $request)
    {
        $cep = $request->validated()['cep'];

        try {

            $response = Cache::rememberForever($cep, function () use ($cep) {
                return $this->service->findAddress($cep);
            });

            return response()->ok(new CepResource($response));

        } catch (Exception $e) {

            Cache::forget($cep);

            return response()->notFound('CEP não encontrado!');
        }
    }
}
