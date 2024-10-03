<?php

namespace App\Http\Controllers\Api\V1\Web\Auth;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserContract;
use App\Services\UserTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseApiController
{

    public function __construct(UserContract $contract)
    {
        parent::__construct($contract, UserResource::class);
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return $this->respondWithModel(auth()->user()->load('roles', 'permissions', 'tokens', 'avatar'));
        }
        return $this->errorWrongArgs(__('messages.wrong_credentials'));
    }
}
