<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;

class MakeCustomRequestCommand extends Command
{
    use MakeCommandTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom-request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a custom request stub';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $template = file_get_contents(base_path('stubs/custom-request.stub'));
        $templateClass = $this->replaceTemplateContent($template, $name);
        $directory = $this->getRequestPath();
        $this->makeDirectory($directory);
        $fileName = $name . 'Request' . '.php';
        $this->info($this->saveTemplateCopy($directory, $fileName, $templateClass));
    }
}
