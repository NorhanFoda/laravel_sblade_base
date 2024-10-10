<?php

namespace App\Http\Controllers\V1\Dashboard;

use App\Http\Requests\TestRequest;
use App\Models\Test;
use App\Repositories\Contracts\TestContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseWebController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TestController extends BaseWebController
{
    /**
     * @return void
     */
    public static function middleware()
    {
        self::permissionMiddlewares('Test');
    }

    /**
     * TestController constructor.
     * @param TestContract $contract
     */
    private string $folderName;
    public function __construct(TestContract $contract)
    {
        $this->folderName = 'V1.Dashboard.tests';
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
     * @param TestRequest $request
     *
     * @return RedirectResponse
     */
    public function store(TestRequest $request): RedirectResponse
    {
        $this->contract->create($request->validated());
        return $this->redirectBack('success', __('messages.actions_messages.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Test $test
     *
     * @return View|Factory|Application
     */
    public function show(Test $test): View|Factory|Application
    {
        return $this->showBlade(['test' => $test]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Test $test
     *
     * @return View|Factory|Application
     */
    public function edit(Test $test): View|Factory|Application
    {
        return $this->editBlade(['test' => $test]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TestRequest $request
     * @param Test $test
     *
     * @return RedirectResponse
     */
    public function update(TestRequest $request, Test $test): RedirectResponse
    {
        $this->contract->update($test, $request->validated());
        return $this->redirectBack('success', __('messages.actions_messages.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Test $test
     *
     * @return RedirectResponse
     */
    public function destroy(Test $test): RedirectResponse
    {
       $this->contract->remove($test);
       return $this->redirectBack('success', __('messages.actions_messages.delete_success'));
    }

    /**
     * active & inactive the specified resource from storage.
     * @param Test $test
     * @return RedirectResponse
     */
    public function changeActivation(Test $test): RedirectResponse
    {
        $this->contract->toggleField($test, 'is_active');
        return $this->redirectBack('success', __('messages.actions_messages.update_success'));
    }
}
