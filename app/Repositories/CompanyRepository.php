<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function model() : string
    {
        return Company::class;
    }

    public function getCompanies(string $filter, int $per_page) : LengthAwarePaginator
    {
        return $this->model->with('category')
            ->where(function ($query) use ($filter) {
                if ($filter != '') {
                    $query->where('name', 'LIKE', "%{$filter}%");
                    $query->orWhere('email', '=', $filter);
                    $query->orWhere('phone', '=', $filter);
                }
            })
            ->paginate($per_page);
    }
}
