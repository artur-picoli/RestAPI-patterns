<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repository\CustomerRepositoryInterface;
use App\Filters\CustomerFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\CreateRequest;
use App\Http\Requests\Api\Customer\UpdateRequest;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {
    }

    public function index(CustomerFilters $filters)
    {
        $data = $this->customerRepository->findAll($filters);

        return CustomerResource::collection($data);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $data = $this->customerRepository->create($validated);

        return response()->created(new CustomerResource($data));
    }


    public function show(string $id)
    {
        $data = $this->customerRepository->findById($id);

        return response()->ok(new CustomerResource($data));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        $data = $this->customerRepository->update($id, $validated);

        return response()->updated(new CustomerResource($data));
    }

    public function destroy(string $id)
    {
        $this->customerRepository->deleteById($id);

        return response()->deleted();
    }
}
