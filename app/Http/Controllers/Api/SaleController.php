<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repository\SaleRepositoryInterface;
use App\Filters\SaleFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Sale\CreateRequest;
use App\Http\Resources\SaleResource;

class SaleController extends Controller
{

    public function __construct(private readonly SaleRepositoryInterface $saleRepository)
    {
    }

    public function index(SaleFilters $filters)
    {
        $data = $this->saleRepository->findAll($filters);

        return SaleResource::collection($data);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $data = $this->saleRepository->create($validated);

        return response()->created(new SaleResource($data));
    }

    public function show(string $id)
    {
        $data = $this->saleRepository->findById($id);

        return response()->ok(new SaleResource($data));
    }

    public function update(CreateRequest $request, string $id)
    {
        $validated = $request->validated();

        $data = $this->saleRepository->update($id, $validated);

        return response()->updated(new SaleResource($data));
    }

    public function destroy(string $id)
    {
        $this->saleRepository->deleteById($id);

        return response()->deleted();
    }
}
