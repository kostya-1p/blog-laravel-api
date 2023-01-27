<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRegisterRequest $request): UserResource
    {
        $user = $this->authService->createUser($request->validated());
        $user->token = $user->createToken("API TOKEN")->plainTextToken;

        return new UserResource($user);
    }

    public function login(UserLoginRequest $request): JsonResponse|UserResource
    {
        if (!$this->authService->tryLogin($request->validated())) {
            return response()->json($this->authService->createInvalidLoginMessage(), 401);
        }

        $user = User::where('email', $request->email)->first();
        $user->token = $user->createToken("API TOKEN")->plainTextToken;
        return new UserResource($user);
    }
}
