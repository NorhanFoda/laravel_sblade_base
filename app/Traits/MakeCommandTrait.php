<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait MakeCommandTrait
{
    protected string $ds = DIRECTORY_SEPARATOR;

    public function saveTemplateCopy($filePath, $fileName, $template): string
    {
        file_put_contents($filePath . $this->ds . $fileName, $template);
        return $fileName . ' has been created';
    }

    public function getTemplate($name): string
    {
        return file_get_contents(base_path('stubs/' . $name . '.stub'));
    }
    public function getAppPath($path): string
    {
        $ds = $this->ds;
        $appBase = app_path() . $ds;
        $path = str_replace('/', $ds, $path);
        $namespace = $path . $ds;
        return $appBase . $namespace;
    }
    public function makeDirectory($directory): ?bool
    {
        if (!is_dir($directory)) {
            return mkdir($directory, 0755, true);
        }
        return null;
    }

    public function getBaseControllerNamespace(): string
    {
        $ds = $this->ds;
        return 'App'. $ds . 'Http' . $ds . 'Controllers' . $ds;
    }

    public function getRepositoriesPath(): string
    {
        $ds = $this->ds;
        $appBase = app_path() . $ds;
        $repositoriesNamespace = 'Repositories' . $ds;
        return $appBase . $repositoriesNamespace;
    }


    public function getNamespace($namespace = null): string
    {
        if (!is_null($namespace)) {
            return  $this->ds . str_replace('/', $this->ds, $namespace) . $this->ds;
        }

        return "";
    }

    public function getRequestPath(): string
    {
        $ds = $this->ds;
        $requestNamespace = 'Http' . $ds . 'Requests' . $ds;
        return app_path() . $ds . $requestNamespace;
    }

    public function getResourcePath(): string
    {
        $ds = $this->ds;
        $resourceNamespace = 'Http' . $ds . 'Resources' . $ds;
        return app_path() . $ds. $resourceNamespace;
    }

    public function replaceTemplateContent($template, $modelName, $namespace = null): array|string
    {
        $search = [
            '{{modelName}}',
            '{{modelNameLower}}',
            '{{modelNamePlural}}',
            '{{namespace}}',
            '{{modelObject}}'
        ];
        $namespace = mb_substr($namespace,  -1) == '/' ? substr($namespace, 0, -1) : $namespace;
        $replace = [
            $modelName,
            Str::lower($modelName),
            Str::plural(Str::lower($modelName)),
            ($namespace) ? '\\' . str_replace('/', '\\', $namespace) : '',
            Str::camel($modelName),
        ];
        return str_replace($search, $replace, $template);
    }

    public function getControllerPath($type, $namespace = null): string
    {
        $ds = $this->ds;
        $controllerNamespace = 'Http' . $ds . 'Controllers' . $ds . $this->getNamespace($namespace);
        if ($type == 'api') {
            $controllerNamespace = 'Http' . $ds . 'Controllers' . $ds . 'Api' . $ds . 'V1' . $ds . $this->getNamespace($namespace);
        }
        return app_path() . $ds . $controllerNamespace;
    }
}
