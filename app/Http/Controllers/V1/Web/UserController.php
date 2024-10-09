<?php

namespace App\Http\Controllers\V1\Web;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\V1\BaseController;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends BaseController implements HasMiddleware
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
        $this->viewName = 'pages.users.index';
        $this->partialViewName = 'pages.users.partials.rows';
        parent::__construct($contract, UserResource::class, $this->viewName, $this->partialViewName);
        $this->relations = ['roles', 'permissions', 'avatar'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->viewName = 'pages.users.form';
        return $this->respondWithModel(new User, [], ['roles' => app(RoleContract::class)->search([], [], ['page' => 0, 'limit' => 0])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        try{
            $user = $this->contract->create($request->validated());
            return $this->respondWithModel($user, ['message' => __('messages.action_completed_successfully')]);
        } catch (Exception $exception) {
            return $this->respondWithError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse|view
     */
    public function show(User $user): JsonResponse|View
    {
        $this->viewName = 'pages.users.show';
        return $this->respondWithModel($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return view
     */
    public function edit(User $user)
    {
        $this->viewName = 'pages.users.form';
        return $this->respondWithModel($user, [], ['roles' => app(RoleContract::class)->search([], [], ['page' => 0, 'limit' => 0])]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user = $this->contract->update($user, $data);
        return $this->respondWithModel($user, ['message' => __('messages.action_completed_successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse|View
    {
        $this->contract->remove($user);
        $this->viewName = 'pages.users.index';
        return $this->respondWithSuccess(__('app.messages.deleted_successfully'));
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
