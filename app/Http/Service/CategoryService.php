<?php

namespace App\Http\Service;

use App\Http\Repository\CategoryRepository;
use Illuminate\Support\Facades\Gate;

class CategoryService {
    public function __construct(protected CategoryRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function newCategory(array $data) {
        Gate::authorize("manageCategories");

        return $this->repository->newCategory($data);
    }

    public function updateCategory(array $data, $id) {
        Gate::authorize("manageCategories");

        return $this->repository->updateCategory($data, $id);
    }

    public function deleteCategory($id) {
        Gate::authorize("manageCategories");

        return $this->repository->deleteCategory($id);
    }
}