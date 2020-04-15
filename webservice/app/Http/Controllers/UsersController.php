<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        $user =  User::create($request->validated());
        return response()->json(['data' => [
            'email' => $user->email,
            'name'  => $user->name
        ]], JsonResponse::HTTP_CREATED);
    }
}
