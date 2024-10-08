<?php

namespace App\Http\Controllers\V1\Web;

use App\Http\Controllers\V1\BaseController;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Repositories\Contracts\PermissionContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class PermissionController extends BaseController
{
    /**
     * PermissionController constructor.
     * @param PermissionContract $repository
     */
    public function __construct(PermissionContract $repository)
    {
        parent::__construct($repository, PermissionResource::class);
    }

    public function __invoke(): Collection|JsonResponse|array
    {
        $models = Permission::all()->groupBy('model');
        return $this->respondWithJson($models);
    }
}
