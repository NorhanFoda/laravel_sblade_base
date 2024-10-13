<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRouteCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:route {modelName} {--type=} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add route to routes/*';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $type = $this->option('type');
        $namespace = $this->option('namespace');
        $modelName = $this->argument('modelName');
        $controllerNamespace = $this->getBaseControllerNamespace() . $ds . 'V1' . $this->getNamespace($namespace);
        if ($type == 'api') {
            $controllerNamespace = $this->getBaseControllerNamespace() . 'Api' . $ds . 'V1' . $this->getNamespace($namespace);
        }
        $controllerNamespace = str_replace('/', '\\', $controllerNamespace);
        $controllerName = $modelName . 'Controller';
        $useStatement = "use $controllerNamespace\\" . $controllerName . ';';
        $routesFilePath = base_path("routes/$type.php");
        $routesContent = File::get($routesFilePath);
        if (!preg_match('/^use.*?' . $controllerName . ';/m', $routesContent)) {
            $routesContent = preg_replace('/^(use .*?;)/m', "$1\n$useStatement", $routesContent, 1);
        }
        $routeName = Str::plural(Str::lower($modelName));
        $namespaceGroup = Str::lower($namespace);
        $route = $type === 'api' ? "Route::apiResource('$routeName', $controllerName::class);" : "Route::resource('$routeName', $controllerName::class);";
        //  $routesContent .= "\n$route\n";
        $namespaceGroup = "Route::as('$namespaceGroup.')->prefix('$namespaceGroup')->group(function () {\n    $route\n});";
        if (!preg_match('/Route::(apiResource|resource)\(\'' . $routeName . '\',\s*' . $controllerName . '::class\);/', $routesContent)) {
            $routesContent .= "\n$namespaceGroup\n";
        }
        File::put($routesFilePath, $routesContent);

        //add route to sidebar
        $sidebarFilePath = base_path("resources/views/" . $namespace . "/layouts/sidebar.blade.php");
        $sidebarContent = File::get($sidebarFilePath);
        //add a route to sidebar by appending it inside ul tag
        /*<x-sidebar.item href="{{ route('users.index') }}" icon="person"
                                label="{{ __('messages.sidebar.users') }}"/>*/
        $modelName = Str::lower($modelName);
        $modelNameRoute = Str::plural($modelName);
        $namespace = Str::lower($namespace);

        $routeLink = "
                    @can('read-$modelName')
                    <x-sidebar.item
                    href=\"{{ route('$namespace.$modelNameRoute.index') }}\"
                    icon=\"person\"
                    label=\"{{ __('messages.sidebar.$modelName') }}\"/>
                    @endcan
                    <li></li>
                    ";
        $sidebarContent = preg_replace('#<li></li>#', (string)$routeLink, $sidebarContent, 1);
        File::put($sidebarFilePath, $sidebarContent);
        $this->info("Route added to routes/$type.php successfully.");
    }
}
