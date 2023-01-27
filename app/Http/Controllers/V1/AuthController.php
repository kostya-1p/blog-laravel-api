<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->token = $user->createToken("API TOKEN")->plainTextToken;

        return new UserResource($user);
    }

    public function login(UserLoginRequest $request): JsonResponse|UserResource
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Email or Password does not match with our record.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $user->token = $user->createToken("API TOKEN")->plainTextToken;
        return new UserResource($user);
    }
}
