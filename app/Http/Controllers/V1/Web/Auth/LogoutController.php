<?php

namespace App\Http\Controllers\V1\Web\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\BaseResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    use BaseResponseTrait;

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */

    private $viewName = 'auth.login';
    public function __invoke(Request $request): JsonResponse|View
    {
        Auth::guard('web')->logout();
        redirect()->route('login.form');
        return $this->respondWithSuccess();
    }
}
