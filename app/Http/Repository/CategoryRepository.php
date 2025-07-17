<?php

namespace App\Http\Repository;

use App\Models\Category;

class CategoryRepository {
    public function getAll() {
        return Category::all();
    }

    public function getOne($id) {
        return Category::findOrFail($id);
    }

    public function newCategory(array $data) {
        return Category::create($data);
    }

    public function updateCategory(array $data, $id) {
        return Category::where($id)->update($data);
    }

    public function deleteCategory($id) {
        return Category::destroy($id);
    }
}