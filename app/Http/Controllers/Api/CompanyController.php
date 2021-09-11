<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends Controller
{

    /** @var CompanyService */
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request) : ResourceCollection
    {
        $per_page = (int) $request->get('per_page', 15);
        $companies = $this->companyService->index($request->get('filter', ''), $per_page);

        return CompanyResource::collection($companies);
    }

    public function store(CompanyRequest $request) : JsonResponse
    {
        $company = $this->companyService->store($request->validated());

        if (!$company) {
            return response()->json(["error" => "Not Saved."], '500');
        }

        return response()->json(["success" => "Company Created!"], '201');
    }

    public function show(string $uuid)
    {
        $company = $this->companyService->show($uuid);

        if(!$company) {
            return response()->json([
                'error'   => 'Company Not Found.',
            ], 404);
        }

        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, string $uuid) : JsonResponse
    {
        $company = $this->companyService->updateByUuid($uuid, $request->validated());

        if(!$company) {
            return response()->json([
                'error'   => 'Company Not Found.',
            ], 404);
        }

        return response()->json(['message' => 'success']);
    }

    public function destroy(string $uuid) : JsonResponse
    {
        $company = $this->companyService->destroy($uuid);

        if(!$company) {
            return response()->json([
                'error'   => 'Company Not Found.',
            ], 404);
        }

        return response()->json(['message' => 'success']);
    }
}
