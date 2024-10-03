<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeVueHttpApiCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue-http-api {modelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Vue Http Api file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modelName = $this->argument('modelName');
        $template = file_get_contents(base_path('stubs/vue/model-api.stub'));
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getVueCompositionsPath();
        $filePath = $directory;
        $fileName = Str::lower($modelName) . '.api.js';
        $this->info($this->saveTemplateCopy($filePath, $fileName, $templateClass));
    }
}
