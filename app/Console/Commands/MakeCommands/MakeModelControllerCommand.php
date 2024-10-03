<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;

class MakeModelControllerCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-controller {modelName} {--type=api} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modelName = $this->argument('modelName');
        $type = $this->option('type');
        $namespace = $this->option('namespace');
        $file = base_path($type == 'web' ? 'stubs/model-controller.web.stub' : 'stubs/model-controller.api.stub');
        $template =  file_get_contents($file);
        $templateClass = $this->replaceTemplateContent($template, $modelName, $namespace);
        $directory = $this->getControllerPath($type, $namespace);
        $this->makeDirectory($directory);
        $fileName = $modelName . 'Controller' . '.php';
        $this->info($this->saveTemplateCopy($directory, $fileName, $templateClass));
    }
}
