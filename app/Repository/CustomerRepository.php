<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\CustomerRepositoryInterface;
use App\Filters\CustomerFilters;
use App\Models\Customer;
use App\Repository\Base\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{

    public function __construct(private readonly Customer $customer)
    {
        parent::__construct($customer);
    }

    public function findAll(CustomerFilters $filters): LengthAwarePaginator
    {
        return $this->model->query()
            ->filter($filters)
            ->latest()
            ->paginate(request()->query('perPage', 10));
    }

    public function create(array $data): Customer
    {
        $this->model->fill($data);

        $this->model->save();

        return $this->model;
    }

    public function update(string $id, array $data): Customer
    {
        $customer = $this->findById($id);

        $customer->fill($data);

        if ($customer->isDirty()) {
            $customer->save();
        }

        return $customer;
    }
}
