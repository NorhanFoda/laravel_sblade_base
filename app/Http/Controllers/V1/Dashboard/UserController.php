<?php

namespace App\Http\Controllers\V1\Dashboard;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\BaseWebController;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\RedirectResponse;


class UserController extends BaseWebController implements HasMiddleware
{
    /**
     * @return void
     */
    public static function middleware()
    {
        self::permissionMiddlewares('User');
    }

    /**
     * UserController constructor.
     * @param UserContract $contract
     */
    public function __construct(UserContract $contract)
    {
        $this->bladeFolderName = 'dashboard.users.';
        parent::__construct($contract);
        $this->relations = ['roles', 'permissions', 'avatar'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|View
     */
    public function create(): View
    {
        return $this->createBlade(['roles' => app(RoleContract::class)->search([], [], ['page' => 0, 'limit' => 0])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(UserRequest $request): JsonResponse|RedirectResponse
    {
        try{
            $model = $this->contract->create($request->validated());
            return $this->redirectBack('success', __('messages.actions_messages.create_success'), $model);
        } catch (Exception $exception) {
            return $this->redirectBack('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return view
     */
    public function show(User $user): View
    {
        return $this->showBlade($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return view
     */
    public function edit(User $user): View
    {
        $user->load('roles');
        $user->setAttribute('role_id', $user->role_id);
        return $this->editBlade($user, ['roles' => app(RoleContract::class)->search([], [], ['page' => 0, 'limit' => 0])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse|RedirectResponse
    {
        try{
            $model = $this->contract->update($user, $request->validated());
            return $this->redirectBack('success', __('messages.actions_messages.update_success'), $model);
        } catch (Exception $exception) {
            return $this->redirectBack('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse|RedirectResponse
    {
        $this->contract->remove($user);
        return $this->redirectBack('success', __('messages.actions_messages.delete_success'));
    }

    /**
     * Change activation status of the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function changeActivation(User $user): JsonResponse
    {
        $this->contract->toggleField($user, 'is_active');
        return $this->respondWithModel($user->load($this->relations));
    }
}
