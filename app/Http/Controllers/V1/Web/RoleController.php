<?php

namespace App\Http\Controllers\Api\V1\Web;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\RoleContract;
use Exception;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseApiController
{

    /**
     * RoleController constructor.
     * @param RoleContract $contract
     */
    public function __construct(RoleContract $contract)
    {
        parent::__construct($contract, RoleResource::class);
    }

    /**
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        try {
            $role = $this->contract->create($request->validated());
            return $this->respondWithModel($role);
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        try {
            return $this->respondWithModel($role->load('permissions'));
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
            $users_id = $role->users()->pluck('id');
            User::whereIn('id',$users_id)->update(['need_logout'=>1]);
            return $this->respondWithModel($role,200,['role-id'=>$role->id,'role-update'=>true]);
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
    public function destroy(Role $role): JsonResponse
    {
        try {
            if (!$role->can_be_deleted)
                return $this->respondWithError(__('role can not be deleted'));
            $this->contract->remove($role);
            return $this->respondWithSuccess(__('role deleted successfully'));
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }
}
