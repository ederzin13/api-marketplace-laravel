<?php

namespace App\Http\Repository;

use App\Models\Address;

class AddressRepository {
    public function getAll() {
        return Address::all();
    }

    public function newAddress(array $data) {
        return Address::create($data);
    }

    public function getOne($id) {
        return Address::findOrFail($id);
    }

    public function updateAddress(array $data, $id) {
        return Address::find($id)->update($data);
    }

    public function deleteAddress($id) {
        return Address::destroy($id);
    }
}