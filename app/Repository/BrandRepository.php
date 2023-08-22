<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\BrandRepositoryInterface;
use App\Filters\BrandFilters;
use App\Models\Brand;
use App\Repository\Base\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{

    public function __construct(private readonly Brand $brand)
    {
        parent::__construct($brand);
    }

    public function findAll(BrandFilters $filters): LengthAwarePaginator
    {
        return $this->model->query()
            ->filter($filters)
            ->paginate(request()->query('perPage', 10));
    }

    public function create(array $data): Brand
    {
        $this->model->fill($data);

        $this->model->save();

        return $this->model;
    }

    public function update(int $id, array $data): Brand
    {

        $brand = $this->findById($id);

        $brand->fill($data);

        if ($brand->isDirty()) {
            $brand->save();
        }
        return $brand;
    }
}
