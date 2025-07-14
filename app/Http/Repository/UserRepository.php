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

    public function getByEmail($email) {
        return User::where("email", $email)->first();
    }

    public function updateOne(array $data) {
        return User::update($data);
    }

    public function deleteOne($id) {
        return User::destroy($id);
    }
}