<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public function store(array $request, UploadedFile $image) : Company
    {
        $path = $this->uploadImage($image);
        $request['image'] = $path;
        return $this->companyRepository->store($request);
    }

    public function updateByUuid(string $uuid, array $request, UploadedFile $image = null) : bool
    {
        $company = $this->companyRepository->findWhereFirst('uuid', $uuid);
        if (!$company) {
            return false;
        }

        if ($image) {
            $company = $this->companyRepository->findWhereFirst('uuid', $uuid);
            if (Storage::exists($company->image)) {
                Storage::delete($company->image);
            }

            $path = $this->uploadImage($image);
            $request['image'] = $path;
        }

        return $this->companyRepository->updateByUuid($uuid, $request);
    }

    public function destroy(string $uuid) : bool
    {
        $company = $this->companyRepository->findWhereFirst('uuid', $uuid);
        if ($company) {
            if (Storage::exists($company->image)) {
                Storage::delete($company->image);
            }
        }

        return $this->companyRepository->deleteByUuid($uuid);
    }

    private function uploadImage(UploadedFile $image)
    {
        return $image->store('companies');
    }
}
