<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\CarRepositoryInterface;
use App\Filters\CarFilters;
use App\Models\Car;
use App\Repository\Base\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CarRepository extends BaseRepository implements CarRepositoryInterface
{

    public function __construct(private readonly Car $car)
    {
        parent::__construct($car);
    }

    public function findAll(CarFilters $filters): LengthAwarePaginator
    {
        return $this->model->query()
            ->with('brand')
            ->filter($filters)
            ->latest()
            ->paginate(request()->query('perPage', 10));
    }

    public function findById(string $id): Car
    {
        return $this->model
            ->query()
            ->with('brand')
            ->findOrFail($id);
    }

    public function create(array $data): Car
    {
        $this->model->fill($data);

        $this->model->save();

        return $this->model->load('brand');
    }

    public function update(string $id, array $data): Car
    {

        $car = $this->findById($id);

        $car->fill($data);

        if ($car->isDirty()) {
            $car->save();
        }
        return $car->load('brand');
    }
}
