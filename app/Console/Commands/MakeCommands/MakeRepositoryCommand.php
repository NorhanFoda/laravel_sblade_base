<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Exception;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class MakeRepositoryCommand extends Command
{
    use MakeCommandTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it takes modelName required, namespace
    & api are optional params for web / api controllers
    & requests and routes';

    protected bool $api = false;
    protected bool $web = false;
    protected bool $mobile = false;
    protected bool $createRoute = true;
    protected string $modelName;
    protected string $modelObject;
    protected string $namespace;

    protected const APP_TYPE_API = 'api';
    protected const APP_TYPE_WEB = 'web';
    protected const APP_TYPE_MOBILE = 'mobile';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {
        $this->getData();
        $this->info('Creating Repository for ' . $this->modelName);
        $this->call('make:model', ['name' => $this->modelName, '-m' => true]);
        echo Artisan::output();
        $this->call('make:contract-repo', ['modelName' => $this->modelName]);
        if ($this->web) {
            $this->call('make:model-controller', ['modelName' => $this->modelName,
                '--type' => 'web', '--namespace' => $this->namespace]);
            if ($this->createRoute) {
                $this->call('make:route', ['modelName' => $this->modelName,
                    '--type' => 'web', '--namespace' => $this->namespace]);
            }
        }
        if ($this->api) {
            $this->call('make:model-controller', ['modelName' => $this->modelName,
                '--type' => 'api', '--namespace' => $this->namespace]);
            $this->call('make:custom-resource', ['name' => $this->modelName]);
            if ($this->createRoute) {
                $this->call('make:route', ['modelName' => $this->modelName,
                    '--type' => 'api', '--namespace' => $this->namespace]);
            }
        }
        $this->call('make:custom-request', ['name' => $this->modelName]);
        if ($this->mobile && $this->createRoute) {
            $this->call('make:route', ['modelName' => $this->modelName,
                '--type' => 'mobile', '--namespace' => $this->namespace]);
        }

        return CommandAlias::SUCCESS;
    }

    private function getData(): void
    {
        // get model name
        $this->modelName = text(
            label: 'Enter model name',
            placeholder: 'E.g. User',
            required: true
        );
        $this->modelObject = Str::camel($this->modelName);
        $this->modelName = ucfirst($this->modelObject);
        // get namespace
        $this->namespace = ucfirst(text(
            label: 'Enter namespace',
        ));
        // get an app type
        $appType = multiselect(
            label: 'Select app type?',
            options: [
                self::APP_TYPE_API => 'Api',
                self::APP_TYPE_WEB => 'Web',
                self::APP_TYPE_MOBILE => 'Mobile',
            ],
            default: [self::APP_TYPE_API],
            required: true
        );
        $this->api = in_array(self::APP_TYPE_API, $appType);
        $this->web = in_array(self::APP_TYPE_WEB, $appType);
        $this->mobile = in_array(self::APP_TYPE_MOBILE, $appType);

        // ask to create routes
        $this->createRoute = confirm(
            label: 'Create the route for you?',
            default: true,
            required: true
        );
    }
}
