<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeVueViewComponentCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue-view-component {modelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Vue View Component';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modelName = $this->argument('modelName');
        $template = file_get_contents(base_path('stubs/vue/pages/view-page.stub'));
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getVueResourcesPath();
        $this->makeDirectory($directory . Str::plural(Str::lower($modelName)));
        $filePath = $directory . Str::plural(Str::lower($modelName));
        $fileName = $modelName . 'View' . '.vue';
        $this->info($this->saveTemplateCopy($filePath, $fileName, $templateClass));
    }
}
