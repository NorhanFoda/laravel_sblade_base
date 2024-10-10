<?php

namespace App\Http\Controllers\V1\Dashboard;

use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PermissionResource;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\BaseWebController;
use App\Repositories\Contracts\PermissionContract;

class PermissionController extends BaseWebController
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
