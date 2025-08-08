<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\GenericResource;
use App\Http\Service\CategoryService;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->service->getAll();

        return new GenericResource($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $this->service->newCategory($request->validated());

        return response()->json([
            "new_category" => new GenericResource($validatedData),
            "message" => "success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = $this->service->getOne($id);

        return new GenericResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $original = $this->service->getOne($id);

        $this->service->updateCategory($request->validated(), $id);

        $updated = $this->service->getOne($id);

        return response()->json([
            "original" => $original,
            "updated" => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedCategory = $this->show($id);

        return response()->json([
            "to_delete" => $deletedCategory,
            "deleted" => $this->service->deleteCategory($id),
        ]);
    }
}
