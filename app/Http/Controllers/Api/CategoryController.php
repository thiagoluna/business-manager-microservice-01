<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    /** @var CategoryService */
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request) : ResourceCollection
    {
        $per_page = (int) $request->get('per_page', 15);
        $categoruies = $this->categoryService->index($per_page);

        return CategoryResource::collection($categoruies);
    }

    public function store(CategoryRequest $request) : JsonResponse
    {
        $category = $this->categoryService->store($request->validated());

        if (!$category) {
            return response()->json(["error" => "Not Saved."], '500');
        }

        return response()->json(["success" => "Company Created!"], '201');
    }

    public function show($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT))
            return response()->json(['error' => 'ID deve ser um número.'], 500);

        $category = $this->categoryService->show($id);

        if(!$category) {
            return response()->json([
                'error'   => 'Company Not Found.',
            ], 404);
        }

        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, $id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT))
            return response()->json(['error' => 'ID deve ser um número.'], 500);

        $category = $this->categoryService->update((int)$id, $request->validated());

        if(!$category) {
            return response()->json([
                'error'   => 'Company Not Found.',
            ], 404);
        }

        return response()->json(['message' => 'success']);
    }

    public function destroy($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT))
            return response()->json(['error' => 'ID deve ser um número.'], 500);

        $category = $this->categoryService->destroy((int)$id);

        if(!$category) {
            return response()->json([
                'error'   => 'Company Not Found.',
            ], 404);
        }

        return response()->json(['message' => 'success']);
    }
}
