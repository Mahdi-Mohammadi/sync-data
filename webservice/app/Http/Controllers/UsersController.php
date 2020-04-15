<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\Outbox;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated());
            Outbox::create([
                'payload' => [
                    'entity'     => User::class,
                    'id'         => $user->id,
                    'email'      => $user->email,
                    'name'       => $user->name,
                    'created_at' => $user->created_at,
                ]
            ]);
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            return response(['message' => 'server terekid'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['message' => 'server terekid'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => [
                'email' => $user->email,
                'name'  => $user->name
            ]
        ], JsonResponse::HTTP_CREATED);
    }
}
