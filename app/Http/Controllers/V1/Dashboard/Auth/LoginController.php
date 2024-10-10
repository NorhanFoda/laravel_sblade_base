<?php

namespace App\Http\Controllers\V1\Dashboard\Auth;

use Illuminate\View\View;
use App\Traits\BaseApiResponseTrait;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Repositories\Contracts\UserContract;
use App\Http\Controllers\BaseWebController;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseWebController
{

    use BaseApiResponseTrait;

    private string $bladeParentFolder = 'V1.Dashboard.';
    
    public function __construct(UserContract $contract)
    {
        parent::__construct($contract);
    }

    /**
     * Display the login form for the user.
     *
     * @return View
     */
    public function getLoginForm(): View
    {
        return view($this->bladeParentFolder. 'auth.login');
    }


    /**
     * Handle an authentication attempt.
     *
     * @param LoginRequest $request
     *
     * @return RedirectResponse|View|JsonResponse
     */
    public function login(LoginRequest $request): RedirectResponse|View|JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remeber = (bool)$request->remember_me;
        if (Auth::attempt($credentials, $remeber)) {
            return $this->redirectTo('home');
        }

        if (request()->ajax()) {
            return $this->errorWrongArgs(__('app.messages.wrong_credentials'));
        }

        return $this->redirectTo('login.form', 'error', __('app.messages.wrong_credentials'));
    }
}
