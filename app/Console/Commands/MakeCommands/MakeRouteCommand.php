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
        $ds = $this->ds;
        $type = $this->option('type');
        $namespace = $this->option('namespace');
        $modelName = $this->argument('modelName');
        $controllerNamespace = $this->getBaseControllerNamespace() . 'Api' . $ds . 'V1' . $this->getNamespace($namespace);
        $controllerNamespace = str_replace('/', '\\', $controllerNamespace);
        $controllerName = $modelName . 'Controller';
        $useStatement = "use $controllerNamespace\\" . $controllerName . ';';
        $routesFilePath = base_path("routes/$type.php");
        $routesContent = File::get($routesFilePath);
        if (!preg_match('/^use.*?'.$controllerName.';/m', $routesContent)) {
            $routesContent = preg_replace('/^(use .*?;)/m', "$1\n$useStatement", $routesContent, 1);
        }
        $routeName = Str::plural(Str::lower($modelName));
        $route = "Route::apiResource('$routeName', $controllerName::class);";
        $routesContent .= "\n$route\n";
        File::put($routesFilePath, $routesContent);
        $this->info("Route added to routes/$type.php successfully.");
    }
}
