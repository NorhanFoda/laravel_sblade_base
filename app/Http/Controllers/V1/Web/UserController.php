<?php

namespace App\Http\Controllers\V1\Web;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

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
        parent::__construct($contract, UserResource::class, $this->viewName);
        $this->relations = ['roles', 'permissions', 'avatar'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->contract->create($data);
        return $this->respondWithModel($user);
    }

    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse|View
    {
        $this->viewName = 'pages.users.view';
        return $this->respondWithModel($user);
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
        return $this->respondWithModel($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->contract->remove($user);
        return $this->respondWithSuccess('User deleted successfully');
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
