<?php

namespace App\Http\Controllers\V1\Dashboard;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\V1\BaseController;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\PermissionContract;

class RoleController extends BaseController
{

    /**
     * @return void
     */
    public static function middleware()
    {
        self::permissionMiddlewares('Role');
    }

    /**
     * RoleController constructor.
     * @param RoleContract $contract
     */
    public function __construct(RoleContract $contract)
    {
        $this->viewName = 'pages.roles.index';
        $this->partialViewName = 'pages.roles.partials.rows';
        parent::__construct($contract, RoleResource::class, $this->viewName, $this->partialViewName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->viewName = 'pages.roles.form';
        return $this->respondWithModel(new Role, [], ['permissions' => app(PermissionContract::class)->search([], [], ['page' => 0, 'limit' => 0, 'groupBy' => 'model'])]);
    }

    /**
     * @param RoleRequest $request
     * @return JsonResponse|View
     */
    public function store(RoleRequest $request): JsonResponse|View
    {
        try {
            DB::beginTransaction();
            $role = $this->contract->create($request->validated());
            DB::commit();
            return $this->respondWithModel($role, ['message' => __('app.messages.action_completed_successfully')]);
        } catch (Exception $exception) {
            DB::rollback();
            return $this->respondWithError($exception->getMessage());
        }
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return view
     */

    public function edit(Role $role)
    {
        $this->viewName = 'pages.roles.form';
        return $this->respondWithModel($role->load('permissions'), [], ['permissions' => app(PermissionContract::class)->search([], [], ['page' => 0, 'limit' => 0, 'groupBy' => 'model'])]);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse|View
    {
        try {
            $this->viewName = 'pages.roles.form';
            return $this->respondWithModel($role->load('permissions'), [], ['permissions' => app(PermissionContract::class)->search([], [], ['page' => 0, 'limit' => 0, 'groupBy' => 'model'])]);
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        try {
            $role = $this->contract->update($role, $request->validated());
            return $this->respondWithModel($role, ['message' => __('app.messages.action_completed_successfully')]);
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse|View
    {
        try {
            $this->viewName = 'pages.roles.index';
            if (!$this->contract->roleCanBeDeleted($role))
                return $this->respondWithError(__('app.messages.role_can_not_be_deleted'));
            $this->contract->remove($role);
            return $this->respondWithSuccess(__('app.messages.deleted_successfully'));
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }
}
