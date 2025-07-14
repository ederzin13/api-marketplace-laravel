<?php

namespace App\Http\Service;

use App\Http\Repository\CategoryRepository;

class CategoryService {
    public function __construct(protected CategoryRepository $repository) {}

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function newCategory(array $data) {
        return $this->repository->newCategory($data);
    }

    public function updateCategory(array $data, $id) {
        return $this->repository->updateCategory($data, $id);
    }

    public function deleteCategory($id) {
        return $this->repository->deleteCategory($id);
    }
}