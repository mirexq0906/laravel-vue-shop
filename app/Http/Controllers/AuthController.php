<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse | ErrorResource
    {
        try {
            $data = $request->validated();
            $user = User::create($data);
            return response()->json($user);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function login(LoginRequest $request): JsonResponse | ErrorResource
    {
        try {
            $data = $request->validated();
            $user = User::where('email', $data['email'])->first();
            if (!isset($user)) {
                throw new Exception('Поле email не верно');
            }
            if (!Hash::check($data['password'], $user->password)) {
                throw new Exception('Пароль не верный');
            }
            $token = $user->createToken('api');
            return response()->json(['token' => $token->plainTextToken, 'data' => $user]);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function check(): JsonResponse | ErrorResource
    {
        try {
            $user = Auth::user();
            if (!$user) {
                throw new Exception('Пользователь не найден');
            }
            return response()->json($user);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
