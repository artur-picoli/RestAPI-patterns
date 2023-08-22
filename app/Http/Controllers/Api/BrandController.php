<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repository\BrandRepositoryInterface;
use App\Filters\BrandFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Brand\CreateRequest;
use App\Http\Requests\Api\Brand\UpdateRequest;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    public function __construct(private readonly BrandRepositoryInterface $BrandRepository)
    {
    }

    public function index(BrandFilters $filters)
    {
        $data = $this->BrandRepository->findAll($filters);

        return BrandResource::collection($data);
    }


    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $data = $this->BrandRepository->create($validated);

        return response()->created(new BrandResource($data));
    }


    public function show(int $id)
    {
        $data = $this->BrandRepository->findById($id);

        return response()->ok(new BrandResource($data));
    }

    public function update(UpdateRequest $request, int $id)
    {
        $validated = $request->validated();

        $data = $this->BrandRepository->update($id, $validated);

        return response()->updated(new BrandResource($data));
    }


    public function destroy(int $id)
    {
        $this->BrandRepository->deleteById($id);

        return response()->deleted();
    }
}
