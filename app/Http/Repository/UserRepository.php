<?php

namespace App\Http\Repository;

use App\Models\User;

class UserRepository {
    public function getAll() {
        return User::all();
    }

    public function newUser(array $data) {
        return User::create($data);
    }

    public function displayOne($id) {
        return User::findOrFail($id);
    }

    public function updateOne(array $data) {
        return User::update($data);
    }
}