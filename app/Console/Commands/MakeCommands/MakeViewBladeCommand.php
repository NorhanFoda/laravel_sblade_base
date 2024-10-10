<?php

namespace App\Console\Commands\MakeCommands;

use App\Traits\MakeCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeViewBladeCommand extends Command
{
    use MakeCommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-view-blade-command {modelName}  {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view blade file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('modelName');
        $permissionName = Str::plural(Str::kebab($modelName));
        $folderName = Str::plural(Str::snake($modelName));
        $namespace = $this->option('namespace');
        $namespace = Str::lower($namespace);
        //remove backslash from namespace if exists from start of the word
        $namespace = ltrim($namespace, '\\');

        //create a form view to include in create and edit
        $formStub = base_path('stubs/views/form.stub');
        $formTemplate = file_get_contents($formStub);
        $formTemplate = $this->replaceTemplateContent($formTemplate, $modelName, $namespace, $folderName,$permissionName);
        $directory = $this->getViewsPath($folderName, $namespace);
        $this->makeDirectory($directory . '/partials');
        $this->saveTemplateCopy($directory . '/partials', '_form.blade.php', $formTemplate);

//create a table view to include in the index
        $tableStub = base_path('stubs/views/table.stub');
        $tableTemplate = file_get_contents($tableStub);
        $tableTemplate = $this->replaceTemplateContent($tableTemplate, $modelName, $namespace, $folderName,$permissionName);
        $directory = $this->getViewsPath($folderName, $namespace);
        $this->makeDirectory($directory . '/partials');
        $this->saveTemplateCopy($directory . '/partials', '_table.blade.php', $tableTemplate);


        $list = [
            'create',
            'edit',
            'index',
            'show'
        ];
        foreach ($list as $item) {
            $createStub = base_path('stubs/views/' . $item . '.stub');
            $createTemplate = file_get_contents($createStub);
            $createTemplate = $this->replaceTemplateContent($createTemplate, $modelName, $namespace, $folderName);
            $directory = $this->getViewsPath($folderName, $namespace);
            $this->makeDirectory($directory);
            $this->saveTemplateCopy($directory, $item . '.blade.php', $createTemplate);
        }
        $this->info('View created successfully!');
    }
}
