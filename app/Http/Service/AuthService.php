<?php

namespace App\Http\Service;

use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; 

class AuthService {
    public function __construct(protected UserRepository $repository) {}
}