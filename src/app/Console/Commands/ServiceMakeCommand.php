<?php

namespace YFDev\System\App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ServiceMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service';
    protected $description = 'Create a new service class';
    protected $type = 'Service';

    protected function getStub()
    {
        return __DIR__ . '/stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    protected function getPath($name)
    {
        $formattedName = $this->getFormattedName();

        return $this->laravel['path'] . '/Services/' . $formattedName . '/' . $formattedName . 'Service.php';
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $formattedName = $this->getFormattedName();

        $stub = str_replace('DummyNamespace', $formattedName, $stub);
        $stub = str_replace('DummyClassService', $formattedName . 'Service', $stub);
        $stub = str_replace('DummyClassRepository', $this->argument('name') . 'Repository', $stub);
        $stub = str_replace('DummyClassTransform', $formattedName . 'Transform', $stub);
        $stub = str_replace('DummyClassInterface', $formattedName . 'RepositoryInterface', $stub);
        $stub = str_replace('DummyModel', $this->argument('name'), $stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    private function getFormattedName()
    {
        return ucfirst($this->argument('name'));
    }
}
