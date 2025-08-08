<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\GenericResource;
use App\Http\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->service->getAll()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        $user = $this->service->newUser($request->validated());

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "message" => "deu certo",
            "token" => $token,
            "data" => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new GenericResource($this->service->displayOne($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $toUpdate = $this->service->displayOne($id);

        $this->service->update($request->validated(), $id);

        $updated = $this->service->displayOne($id);

        return response()->json([
            "original" => $toUpdate,
            "updated" => $updated
        ]);
    }

    public function createModerator(Request $request) {
        $email = $request->only(["email"]);

        return response()->json([
            "new_mod" => $this->service->updateRole($email)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $toDelete = $this->service->displayOne($id);

        $this->service->deleteOne($id);

        return response()->json([
            "to_delete" => $toDelete,
            "message" => "deletado"
        ]);
    }
}
