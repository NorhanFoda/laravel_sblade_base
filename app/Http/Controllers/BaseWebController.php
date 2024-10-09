<?php


namespace App\Http\Controllers\V1;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Repositories\Contracts\BaseContract;
use Illuminate\Routing\Controllers\Middleware;

class BaseWebController extends Controller
{
    protected bool $order = true;
    protected BaseContract $contract;
    protected array $relations = [];
    protected string $bladeFolderName;
    protected string $indexPath = 'index';
    protected string $indexRowsPath = 'partials.rows';

    public function __construct(BaseContract $contract, string $bladeFolderName)
    {
        $this->contract = $contract;
        $this->bladeFolderName = $bladeFolderName;
        if (request()->has('embed')) {
            $this->parseIncludes(request('embed'));
        }
    }

    /**
     * index() Display a listing of the resource.
     *
     * @return JsonResponse|View
     */
    public function index(): View
    {
        $page = request('page', 1);
        $limit = request('limit', 10);
        $order = request('order', []);
        $filters = request()->all();
        
        $data = array_merge($filters, ['order' => $order, 'limit' => $limit, 'page' => $page]);
        $models = $this->contract->search($filters, $this->relations, $data);

        if (request()->ajax()) {
            return $this->indexBlade($models, $this->indexRowsPath);
        }

        return $this->indexBlade($models, $this->indexPath);
    }
    
    /**
     * indexBlade() Render a Blade view for index.
     *
     * @param mixed $models
     * @param string $path
     * @return View
     */
    protected function indexBlade($models, $path): View
    {
        return view($this->bladeFolderName . '.' . $path, compact('models'));
    }

    /**
     * createBlade() Render a Blade view for create.
     *
     * @param mixed $data
     * @return View
     */
    protected function createBlade($data = null): View
    {
        return view($this->bladeFolderName . '.create', compact('data'));
    }


    /**
     * editBlade() Render a Blade view for edit.
     *
     * @param mixed $model
     * @param mixed $data
     * @return View
     */
    protected function editBlade($model, $data = null): View
    {
        return view($this->bladeFolderName . '.edit', compact('model', 'data'));
    }

    /**
     * showBlade() Render a Blade view for show.
     *
     * @param mixed $model
     * @param mixed $data
     * @return View
     */
    protected function showBlade($model, $data = null): View
    {
        return view($this->bladeFolderName . '.show', compact('model', 'data'));
    }

    /**
     * redirectBack() used to redirect back to the previous page with the
     * given status and message.
     *
     * @param string $status
     * @param string $message
     * @return RedirectResponse
     */
    protected function redirectBack($status = 'success', $message = ''): RedirectResponse
    {
        return redirect()->back()->with($status, $message);
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
}