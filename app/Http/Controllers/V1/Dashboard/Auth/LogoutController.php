<?php

namespace App\Http\Controllers\V1\Dashboard\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function __invoke(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        return redirect()->route('login.form');
    }
}
