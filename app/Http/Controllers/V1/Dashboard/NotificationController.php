<?php

namespace App\Http\Controllers\V1\Dashboard;

use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Repositories\Contracts\NotificationContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseWebController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationController extends BaseWebController
{
    /**
     * @return void
     */
    public static function middleware()
    {
        self::permissionMiddlewares('Notification');
    }

    /**
     * NotificationController constructor.
     * @param NotificationContract $contract
     */
    private string $folderName;
    public function __construct(NotificationContract $contract)
    {
        $this->bladeFolderName  = 'Dashboard.notifications';
        parent::__construct($contract);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return $this->createBlade();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NotificationRequest $request
     *
     * @return RedirectResponse
     */
    public function store(NotificationRequest $request): RedirectResponse
    {
        $this->contract->create($request->validated());
        return $this->redirectBack('success', __('messages.actions_messages.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Notification $notification
     *
     * @return View|Factory|Application
     */
    public function show(Notification $notification): View|Factory|Application
    {
        return $this->showBlade(['notification' => $notification]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Notification $notification
     *
     * @return View|Factory|Application
     */
    public function edit(Notification $notification): View|Factory|Application
    {
        return $this->editBlade(['notification' => $notification]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NotificationRequest $request
     * @param Notification $notification
     *
     * @return RedirectResponse
     */
    public function update(NotificationRequest $request, Notification $notification): RedirectResponse
    {
        $this->contract->update($notification, $request->validated());
        return $this->redirectBack('success', __('messages.actions_messages.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notification $notification
     *
     * @return RedirectResponse
     */
    public function destroy(Notification $notification): RedirectResponse
    {
       $this->contract->remove($notification);
       return $this->redirectBack('success', __('messages.actions_messages.delete_success'));
    }

    /**
     * active & inactive the specified resource from storage.
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function changeActivation(Notification $notification): RedirectResponse
    {
        $this->contract->toggleField($notification, 'is_active');
        return $this->redirectBack('success', __('messages.actions_messages.update_success'));
    }
}
