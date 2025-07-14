<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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
        return response()->json($this->service->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $this->service->newCategory($request->validated());

        return response()->json([
            "new_category" => $validatedData,
            "message" => "success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($this->service->getOne($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $toUpdate = $this->service->getOne($id);

        $validatedData = $this->service->updateCategory($request->validated(), $id);

        return response()->json([
            "original" => $toUpdate,
            "updated" => $validatedData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            "to_delete" => $this->show($id),
            "deleted" => $this->service->deleteCategory($id),
            "status" => "success"
        ]);
    }
}
