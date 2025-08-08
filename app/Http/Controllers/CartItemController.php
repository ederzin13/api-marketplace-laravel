<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Resources\GenericResource;
use App\Http\Service\CartItemService;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function __construct(protected CartItemService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->service->getItems();

        return GenericResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $validatedData = $this->service->addItem($request->validated());

        return response()->json([
            "added_item" => $request->all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($this->service->getOneItem($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, $id)
    {
        $original = $this->show($id);

        $this->service->updateItem($request->validated(), $id);

        return response()->json([
            "to_update" => $original,
            "updated" => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $toDelete = $this->show($id);

        return response()->json([
            "to_delete" => $toDelete,
            "deleted" => $this->service->removeItem($id)
        ]);
    }

    public function clear() {
        return response()->json([
            "Carrinho limpo" => $this->service->clear()
        ]);
    }
}
