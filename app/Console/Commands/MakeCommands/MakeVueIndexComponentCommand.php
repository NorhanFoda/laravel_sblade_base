<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeVueIndexComponentCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue-index-component {modelName} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Vue Index Component';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modelName = $this->argument('modelName');
        $type = $this->option('type') == 'modal' ? 'modal' : 'page';
        $template = file_get_contents(base_path("stubs/vue/pages/index-page-form-$type.stub"));
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getVueResourcesPath();
        $this->makeDirectory($directory . Str::plural(Str::lower($modelName)));
        $filePath = $directory . Str::plural(Str::lower($modelName));
        $fileName = $modelName . 'Index' . '.vue';
        $this->info($this->saveTemplateCopy($filePath, $fileName, $templateClass));
    }
}
