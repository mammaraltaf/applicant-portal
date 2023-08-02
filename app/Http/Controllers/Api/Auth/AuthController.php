<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\StatusEnum;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /*Login*/
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->sendError(['credentials' => ['Invalid credentials.']], 401);
        } elseif (auth()->user()->email_verified_at == null) {
            return $this->sendError(['verified' => ['Please Verify your email']], 401);
        }

        $user = auth()->user();

        if (empty($user->email_verified_at)) {
            return $this->sendError(['credentials' => ['Email is not verified.']],);
        }

        $token = $user->createToken(StatusEnum::AUTH_TOKEN)->accessToken;

        return $this->sendResponse(['access_token' => $token, 'user' => $user->name, 'email' => $user->email], 'user has been login to the system');
    }


    /*Logout*/
    public function logout(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return $this->sendResponse([], 'User logged out successfully.');
        }
        return $this->sendError(['error' => ['Invalid operation.']]);
    }
}
