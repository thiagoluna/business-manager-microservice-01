<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\CompanyRepositoryInterface;

class CompanyService
{
    /** @var CompanyRepositoryInterface */
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(string $filter, int $per_page)
    {
        return $this->companyRepository->getCompanies($filter, $per_page);
    }

    public function show(string $uuid)
    {
        return $this->companyRepository->findWhereFirst("uuid", $uuid);
    }

    public function store($request) : bool
    {
        $company = $this->companyRepository->store($request);

        if (!$company) {
            return false;
        }

        return true;
    }

    public function updateByUuid(string $uuid, array  $request) : bool
    {
        return $this->companyRepository->updateByUuid($uuid, $request);
    }

    public function destroy(string $uuid) : bool
    {
        return $this->companyRepository->deleteByUuid($uuid);
    }
}
