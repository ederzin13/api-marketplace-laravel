<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateProductStockRequest;
use App\Http\Resources\ProductResource;
use App\Http\Service\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->service->getAll();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $this->service->newProduct($request->validated());

        return response()->json([
            "message" => "produto adicionado",
            "product" => new ProductResource($validatedData)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->service->getOne($id);

        $product->load("category");

        return response()->json([
            "product" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $toUpdate = $this->service->getOne($id);

        $this->service->updateProduct($request->validated(), $id);

        $updated = $this->service->getOne($id);

        return response()->json([
            "original" => $toUpdate,
            "updated" => $updated
        ]);
    }

    public function updateStock(UpdateProductStockRequest $request, $id) {
        $validatedData = $this->service->updateProduct($request->validated(), $id);

        return response()->json([
            "message" => "updated stock",
            "new_value" => $request->stock
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedProduct = $this->show($id);

        
        return response()->json([
            "to_delete" => $deletedProduct,
            "deleted" => $this->service->deleteProduct($id)
        ]);
    }
}
