<?php

namespace App\Http\Controllers\V1\Dashboard;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class HomeController implements HasMiddleware
{
    private string $bladeParentFolder = 'dashboard.';
    /**
     * @return void
     */
    public static function middleware()
    {
        // self::permissionMiddlewares('User');
    }

    /**
     * HomeController constructor.
     */
    public function __construct() { }

    /**
     * index() Display a listing of the resource.
     *
     * @return JsonResponse|View
     */
    public function index(): JsonResponse|View
    {
        return view($this->bladeParentFolder. 'home');
    }
}
