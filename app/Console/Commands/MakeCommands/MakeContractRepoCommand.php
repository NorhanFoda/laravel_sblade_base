<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;

class MakeContractRepoCommand extends Command
{
    use MakeCommandTrait;

    private string $modelName;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract-repo {modelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract repository';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->modelName = $this->argument('modelName');
        $this->createRepository();
        $this->createContract();
    }

    public function createRepository(): void
    {
        $modelName = $this->modelName;
        $template = file_get_contents(base_path('stubs/repository.stub'));
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getRepositoriesPath();
        $this->makeDirectory($directory . 'SQL');
        $filePath = $directory . 'SQL';
        $fileName = $modelName . 'Repository' . '.php';
        $this->info($this->saveTemplateCopy($filePath, $fileName, $templateClass));
    }

    public function createContract(): void
    {
        $modelName = $this->modelName;
        $template = file_get_contents(base_path('stubs/contract.stub'));
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getRepositoriesPath();
        $this->makeDirectory($directory . 'Contracts');
        $filePath = $directory . 'Contracts';
        $fileName = $modelName . 'Contract' . '.php';
        $this->info($this->saveTemplateCopy($filePath, $fileName, $templateClass));
    }

}
