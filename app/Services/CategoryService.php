<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Str;

class CategoryService
{
    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(int $per_page)
    {
        return $this->categoryRepository->orderBy('title', 'ASC')->paginate($per_page);
    }

    public function show($id)
    {
        return $this->categoryRepository->findWhereFirst("id", $id);
    }

    public function store($request) : bool
    {
        $company = $this->categoryRepository->store($request);

        if (!$company) {
            return false;
        }

        return true;
    }

    public function update(int $id, array  $request) : bool
    {
        return $this->categoryRepository->update($id, $request);
    }

    public function destroy(int $id) : bool
    {
        return $this->categoryRepository->delete($id);
    }
}
