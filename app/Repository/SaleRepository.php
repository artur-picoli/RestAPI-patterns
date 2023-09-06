<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\SaleRepositoryInterface;
use App\Filters\SaleFilters;
use App\Models\Sale;
use App\Repository\Base\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;


class SaleRepository extends BaseRepository implements SaleRepositoryInterface
{
    public function __construct(private readonly Sale $sale)
    {
        parent::__construct($sale);
    }

    public function findAll(SaleFilters $filters): LengthAwarePaginator
    {
        return $this->model
            ->query()
            ->with('car.brand')
            ->filter($filters)
            ->latest()
            ->paginate(request()->query('perPage', 10));
    }

    public function findById(string $id): Model
    {
        return $this->model
            ->query()
            ->with('car.brand')
            ->findOrFail($id);
    }

    public function create(array $data): Sale
    {
        $this->model->fill($data);

        $this->model->save();

        return $this->model->load(['car.brand', 'customer']);
    }

    public function update(string $id, array $data): Sale
    {
        $sale = $this->findById($id);

        $sale->fill($data);

        if ($sale->isDirty()) {
            $sale->save();
        }

        return $sale;
    }
}
