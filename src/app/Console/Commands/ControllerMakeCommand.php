<?php

namespace YFDev\System\App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ControllerMakeCommand extends GeneratorCommand
{
    protected $name = 'make:controller';
    protected $description = 'Create a new custom controller class';
    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub'; // 請確保你有在此路徑下建立你的 controller.stub
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    protected function getPath($name)
    {
        $formattedName = $this->getFormattedName();
        return $this->laravel['path'] . '/Http/Controllers/' . $formattedName . 'Controller.php';
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $formattedName = $this->getFormattedName();

        $stub = str_replace('DummyNamespace', $formattedName, $stub);
        $stub = str_replace('DummyClassController', $formattedName . 'Controller', $stub);
        $stub = str_replace('DummyService', $this->argument('name') . 'Service', $stub);
        $stub = str_replace('DummyClassService', $formattedName . 'Service', $stub);
        $stub = str_replace('DummyModel', '$' . $this->argument('name'), $stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    private function getFormattedName()
    {
        return ucfirst($this->argument('name'));
    }
}
