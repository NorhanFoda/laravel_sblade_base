<?php

namespace App\Http\Controllers\V1\Web\Auth;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\UserTokenService;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\V1\BaseController;
use App\Repositories\Contracts\UserContract;

class LoginController extends BaseController
{

    public function __construct(UserContract $contract)
    {
        parent::__construct($contract, UserResource::class);
    }

    public function getLoginForm(): View
    {
        return view('auth.login');
    }


    /**
     * Handle an authentication attempt.
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse|View
     */
    public function login(LoginRequest $request): JsonResponse|View
    {
        $credentials = $request->only('email', 'password');
        $remeber = (bool)$request->remember_me;
        if (Auth::attempt($credentials, $remeber)) {
            return $this->respondWithModel(auth()->user()->load('roles', 'permissions', 'tokens', 'avatar'));
        }
        return $this->errorWrongArgs(__('app.messages.wrong_credentials'));
    }
}
