<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeVueRouteCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue-route {modelName} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add Vue Route';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $ds = $this->ds;
        $modelName = $this->argument('modelName');
        $type = $this->option('type') == 'modal' ? 'modal' : 'page';
        $routeFilePath = $this->getVueRoutePath() . '/dashboard-routes.js';
        $routesContent = File::get($routeFilePath);
        $lastBracePosition = strrpos($routesContent, '}');
        if ($lastBracePosition === false) {
            throw new Exception('No closing brace found in the file.');
        }
        $commaPosition = strpos($routesContent, ',', $lastBracePosition);
        if ($commaPosition !== false) {
            $routesContent = substr_replace($routesContent, '', $commaPosition, 1);
        }
        $modelName = ucfirst($modelName);
        $routeName = Str::plural(Str::lower($modelName));
        $componentsPath = "@views" . $ds . $routeName . $ds;
        $indexPath = $componentsPath . $modelName . 'Index.vue';
        $formPath = $componentsPath . $modelName . 'Form.vue';
        $viewPath = $componentsPath . $modelName . 'View.vue';
        if ($type === 'page') {
            $newRoute = <<<EOD
                ,{
                    path: "/$routeName",
                    name: "$routeName",
                    component: () => import("$indexPath"),
                    meta: {
                        requiresAuth: true,
                        title: t("sidebar.$routeName"),
                        action: "read",
                        module: "$modelName",
                    },
                },
                {
                    path: "/$routeName/create",
                    name: "$routeName.create",
                    component: () => import("$formPath"),
                    meta: {
                        requiresAuth: true,
                        title: t("sidebar.$routeName"),
                        action: "create",
                        module: "$modelName",
                    },
                },
                {
                    path: "/$routeName/edit/:id?",
                    name: "$routeName.edit",
                    component: () => import("$formPath"),
                    meta: {
                        requiresAuth: true,
                        title: t("sidebar.$routeName"),
                        action: "update",
                        module: "$modelName",
                    },
                },
                {
                    path: "/$routeName/view/:id?",
                    name: "$routeName.show",
                    component: () => import("$viewPath"),
                    meta: {
                        requiresAuth: true,
                        title: t("sidebar.$routeName"),
                        action: "read",
                        module: "$modelName",
                    },
                },
                EOD;
        } else {
            $newRoute = <<<EOD
                ,{
                    path: "/$routeName",
                    name: "$routeName",
                    component: () => import("$indexPath"),
                    meta: {
                        requiresAuth: true,
                        title: t("sidebar.$routeName"),
                        action: "read",
                        module: "$modelName",
                    },
                },
                {
                    path: "/$routeName/view/:id?",
                    name: "$routeName.show",
                    component: () => import("$viewPath"),
                    meta: {
                        requiresAuth: true,
                        title: t("sidebar.$routeName"),
                        action: "read",
                        module: "$modelName",
                    },
                },
                EOD;
        }
        $newFileContent = substr_replace($routesContent, $newRoute, $lastBracePosition + 1, 0);
        File::put($routeFilePath, $newFileContent);
        $this->info("Routes added to dashboard-routes.js successfully.");
    }
}
