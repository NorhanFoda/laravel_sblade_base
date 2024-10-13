<?php


namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Repositories\Contracts\BaseContract;
use App\Traits\BaseApiResponseTrait;
use Illuminate\Routing\Controllers\Middleware;

class BaseWebController extends Controller
{
    use BaseApiResponseTrait;
    
    protected bool $order = true;
    protected BaseContract $contract;
    protected array $relations = [];
    protected string $bladeFolderName;
    protected string $indexPath = 'index';
    protected string $createPath = 'create';
    protected string $editPath = 'edit';
    protected string $showPath = 'show';
    protected string $indexRowsPath = 'partials._table';

    public function __construct(BaseContract $contract)
    {
        $this->contract = $contract;
        if (request()->has('embed')) {
            $this->parseIncludes(request('embed'));
        }
    }

    /**
     * index() Display a listing of the resource.
     *
     * @return JsonResponse|View
     */
    public function index(): View|JsonResponse
    {
        $page = request('page', 1);
        $limit = request('limit', 10);
        $order = request('order', []);
        $filters = request()->all();
        
        $data = array_merge($filters, ['order' => $order, 'limit' => $limit, 'page' => $page]);
        $models = $this->contract->search($filters, $this->relations, $data);

        if (request()->ajax()) {
            return $this->indexBlade($models, null, $this->indexRowsPath);
        }

        return $this->indexBlade($models, null, $this->indexPath);
    }
    
    /**
     * indexBlade() Render a Blade view for index.
     *
     * @param mixed $models
     * @param string $path
     * @return View
     */
    protected function indexBlade($models, $data = null,  $path = ''): View|JsonResponse
    {
        if (request()->ajax()) {
            return response()->json([
                'html' => view($this->bladeFolderName . $path, ['models' => $models])->render(),
                'totalEntries' => $models->total(),
                'currentPage' => $models->currentPage(),
                'totalPages' => $models->lastPage()
            ]);
        }
        return view($this->bladeFolderName . $path, compact('models', 'data'));
    }

    /**
     * createBlade() Render a Blade view for create.
     *
     * @param mixed $data
     * @return View
     */
    protected function createBlade($data = null, $path = ''): View
    {
        return view($this->bladeFolderName . ($path !== '' ? $path : $this->createPath), compact('data'));
    }


    /**
     * editBlade() Render a Blade view for edit.
     *
     * @param mixed $model
     * @param mixed $data
     * @return View
     */
    protected function editBlade($model, $data = null, $path = ''): View
    {
        return view($this->bladeFolderName . ($path !== '' ? $path : $this->editPath), compact('model', 'data'));
    }

    /**
     * showBlade() Render a Blade view for show.
     *
     * @param mixed $model
     * @param mixed $data
     * @return View
     */
    protected function showBlade($model, $data = null, $path = ''): View
    {
        return view($this->bladeFolderName . ($path !== '' ? $path : $this->showPath), compact('model', 'data'));
    }

    /**
     * redirectBack() used to redirect back to the previous page with the
     * given status and message.
     *
     * @param string $status
     * @param string $message
     * @return RedirectResponse|JsonResponse
     */
    protected function redirectBack($status = 'success', $message = '', $data = null): RedirectResponse|JsonResponse
    {
        if (request()->ajax()) {
            return $this->respondWithModel($data, $message, $status);
        }
        return redirect()->back()->with($status, $message);
    }

    protected function redirectTo($route, $data = null, $status = 'success', $message = ''): RedirectResponse
    {
        return redirect()->route($route)->with($status, $message, $data);
    }

    /**
     * parseIncludes() used to explode embed relations array
     *
     * @param $embed
     */
    protected function parseIncludes($embed): void
    {
        $this->relations = explode(',', $embed);
    }

    /**
     * model middlewares for permissions
     *
     * @param string $model
     * @param string $applies = '*' , r,c,u,d
     * @return array
     */
    public static function permissionMiddlewares(string $model, string $applies = '*'): array
    {
        $middlewares = [];
        $applies = explode(',', $applies);
        if (in_array('r', $applies) || in_array('*', $applies)) {
            $middlewares['r'] = new Middleware('permission:read-' . $model, only: ['index', 'show']);
        }
        if (in_array('c', $applies) || in_array('*', $applies)) {
            $middlewares['c'] = new Middleware('permission:create-' . $model, only: ['create', 'store']);
        }
        if (in_array('u', $applies) || in_array('*', $applies)) {
            $middlewares['u'] = new Middleware('permission:update-' . $model, only: ['edit', 'update']);
        }
        if (in_array('d', $applies) || in_array('*', $applies)) {
            $middlewares['d'] = new Middleware('permission:delete-' . $model, only: ['destroy']);
        }
        return $middlewares;
    }

    /**
     * respondWithModel() used to return result with one model relation
     *
     * @param $model
     * @param string $message
     * @return JsonResponse
     */
    protected function respondWithModel($model, $message = '', $status = ''): JsonResponse
    {
        return response()->json([
            'model' => $model,
            'message' => $message,
            'status' => $status
        ]);
    }
}