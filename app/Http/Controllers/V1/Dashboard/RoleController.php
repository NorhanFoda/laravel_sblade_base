<?php

namespace App\Http\Controllers\V1\Dashboard;

use Exception;
use App\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\BaseWebController;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\PermissionContract;
use Illuminate\Http\RedirectResponse;

class RoleController extends BaseWebController
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
        $this->bladeFolderName = 'dashboard.roles.';
        parent::__construct($contract);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|View
     */
    public function create(): View
    {
        return $this->createBlade(['permissions' => app(PermissionContract::class)->search([], [], ['page' => 0, 'limit' => 0, 'groupBy' => 'model'])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(RoleRequest $request): JsonResponse|RedirectResponse
    {
        try{
            DB::beginTransaction();
            $model = $this->contract->create($request->validated());
            DB::commit();
            return $this->redirectBack('success', __('messages.actions_messages.create_success'), $model);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->redirectBack('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return view
     */
    public function show(Role $role): View
    {
        return $this->showBlade($role->load('permissions'), ['permissions' => app(PermissionContract::class)->search([], [], ['page' => 0, 'limit' => 0, 'groupBy' => 'model'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return view
     */
    public function edit(Role $role): View
    {
        return $this->editBlade($role->load('permissions'), ['permissions' => app(PermissionContract::class)->search([], [], ['page' => 0, 'limit' => 0, 'groupBy' => 'model'])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role): JsonResponse|RedirectResponse
    {
        try{
            $model = $this->contract->update($role, $request->validated());
            return $this->redirectBack('success', __('messages.actions_messages.update_success'), $model);
        } catch (Exception $exception) {
            return $this->redirectBack('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse|RedirectResponse
    {
        if (!$this->contract->roleCanBeDeleted($role)) {
            if (request()->ajax()) {
                return $this->respondWithError(__('messages.actions_messages.item_can_not_be_deleted'));
            }
            return $this->redirectBack('error', __('messages.actions_messages.item_can_not_be_deleted'));
        }
        $this->contract->remove($role);
        return $this->redirectBack('success', __('messages.actions_messages.delete_success'));
    }

    /**
     * Change activation status of the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function changeActivation(Role $role): JsonResponse
    {
        $this->contract->toggleField($role, 'is_active');
        return $this->respondWithModel($role->load($this->relations));
    }

}
