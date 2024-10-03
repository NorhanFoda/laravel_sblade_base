<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BaseContract;
use App\Traits\BaseResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    use BaseResponseTrait;

    protected bool $order = true;
    protected BaseContract $contract;
    protected mixed $modelResource;
    protected array $relations = [];
    protected string $viewName;

    /**
     * BaseApiController constructor.
     *
     * @param BaseContract $contract
     * @param mixed $modelResource
     */
    public function __construct(BaseContract $contract, mixed $modelResource, string $viewName = '')
    {
        $this->contract = $contract;
        $this->modelResource = $modelResource;
        $this->viewName = $viewName;
        if (request()->has('embed')) {
            $this->parseIncludes(request('embed'));
        }
    }

    /**
     * index() Display a listing of the resource.
     *
     * @return JsonResponse|View
     */
    public function index(): JsonResponse|View
    {
        $page = request('page', 1);
        $limit = request('limit', 10);
        $order = request('order', []);
        $filters = request()->all();
        
        $data = array_merge($filters, ['order' => $order, 'limit' => $limit, 'page' => $page]);
        $models = $this->contract->search($filters, $this->relations, $data);

        // Check if the request expects a JSON response or a view
        if (request()->wantsJson()) {
            return $this->respondWithCollection($models);
        }

        // Render the view with the models data
        return $this->renderView($this->viewName, compact('models')); // Specify your view name
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
     * renderView() to render a Blade view.
     *
     * @param string $view
     * @param array $data
     * @return View
     */
    protected function renderView(string $view, array $data = []): View
    {
        return view($view, $data);
    }

    /**
     * respondWithCollection() used to take collection
     * and return its data transformed by resource response
     *
     * @param $collection
     * @return JsonResponse|View
     */
    protected function respondWithCollection($collection): JsonResponse|View
    {
        $resources = forward_static_call([$this->modelResource, 'collection'], $collection);

        // Check if the request expects a JSON response or a view
        if (request()->wantsJson()) {
            return $this->respond($resources);
        }

        return $this->renderView('your.collection.view.name', compact('resources')); // Specify your collection view name
    }

    /**
     * respondWithGroupByCollection() used to take group by collection
     * and return its data transformed by resource response
     *
     * @param $models
     * @param string $groupBy
     * @return JsonResponse|View
     */
    protected function respondWithGroupByCollection($models, string $groupBy): JsonResponse|View
    {
        $groupedModels = $models->map(function ($items, $key) use ($groupBy) {
            $model = $items->first()->getModel();
            $casts = $model->getCasts();
            $groupBy = str_replace('.value', '', $groupBy);
            if (array_key_exists($groupBy, $casts) && preg_match("/\bConstants\b/i", $casts[$groupBy])) {
                $key = $model->getCasts()[$groupBy]::getLabels()[$key];
            }
            return [
                'groupBy' => $key,
                'items' => forward_static_call([$this->modelResource, 'collection'], $items)
            ];
        })->all();

        // Check if the request expects a JSON response or a view
        if (request()->wantsJson()) {
            return $this->respondWithArray(['data' => $groupedModels]);
        }

        return $this->renderView('your.grouped.collection.view.name', compact('groupedModels')); // Specify your grouped collection view name
    }

    /**
     * respondWithModel() used to return result with one model relation
     *
     * @param $model
     * @return JsonResponse|View
     */
    protected function respondWithModel($model): JsonResponse|View
    {
        $resource = new $this->modelResource($model->load($this->relations));

        // Check if the request expects a JSON response or a view
        if (request()->wantsJson()) {
            return $this->respond($resource);
        }

        return $this->renderView($this->viewName, compact('resource')); // Specify your model view name
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
            $middlewares['c'] = new Middleware('permission:create-' . $model, only: ['store']);
        }
        if (in_array('u', $applies) || in_array('*', $applies)) {
            $middlewares['u'] = new Middleware('permission:update-' . $model, only: ['update']);
        }
        if (in_array('d', $applies) || in_array('*', $applies)) {
            $middlewares['d'] = new Middleware('permission:delete-' . $model, only: ['destroy']);
        }
        return $middlewares;
    }
}
