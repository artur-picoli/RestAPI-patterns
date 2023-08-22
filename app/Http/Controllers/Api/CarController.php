<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repository\CarRepositoryInterface;
use App\Filters\CarFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Car\CreateRequest;
use App\Http\Requests\Api\Car\UpdateRequest;
use App\Http\Resources\Car\CarResource;

class CarController extends Controller
{
    public function __construct(private readonly CarRepositoryInterface $carRepository)
    {
    }

    public function index(CarFilters $filters)
    {
        $data = $this->carRepository->findAll($filters);

        return CarResource::collection($data);
    }


    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $data = $this->carRepository->create($validated);

        return response()->created(new CarResource($data));
    }


    public function show(int $id)
    {
        $data = $this->carRepository->findById($id);

        return response()->ok(new CarResource($data));
    }

    public function update(UpdateRequest $request, int $id)
    {
        $validated = $request->validated();

        $data = $this->carRepository->update($id, $validated);

        return response()->updated(new CarResource($data));
    }


    public function destroy(int $id)
    {
        $this->carRepository->deleteById($id);

        return response()->deleted();
    }
}
