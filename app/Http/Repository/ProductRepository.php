<?php

namespace App\Http\Repository;

use App\Models\Product;

class ProductRepository {
    public function getAll() {
        return Product::all();
    }

    public function getOne($id) {
        return Product::findOrFail($id);
    }

    public function newProduct(array $data) {
        return Product::create($data);
    }

    public function updateProduct(array $data, $id) {
        return Product::where("id", "=", $id)->update($data);
    }

    public function deleteProduct($id) {
        return Product::destroy($id);
    }
}