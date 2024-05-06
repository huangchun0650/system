<?php

namespace YFDev\System\App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class RepositoryMakeCommand extends GeneratorCommand
{
    protected $name = 'make:repository';
    protected $description = 'Create a new repository class and its interface';
    protected $type = 'Repository';

    public function handle()
    {
        parent::handle();

        $this->createInterface();
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Repositories';
    }

    protected function getPath($name, $isInterface = FALSE)
    {
        $formattedName = $this->getFormattedName();

        $filename = $isInterface ? $formattedName . 'RepositoryInterface.php' : $formattedName . 'Repository.php';

        return $this->laravel['path'] . '/Repositories/' . $formattedName . '/' . $filename;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
        ];
    }

    protected function getFormattedName()
    {
        return ucfirst(strtolower($this->argument('name')));
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $formattedName = $this->getFormattedName();

        // 替換命名空間
        $stub = str_replace('DummyNamespace', $formattedName, $stub);

        // 替換類名
        $stub = str_replace('DummyClass', $formattedName, $stub);

        // 替換模型名稱
        $stub = str_replace('DummyModel', $formattedName, $stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function createInterface()
    {
        $name = $this->qualifyClass($this->getFormattedName() . 'RepositoryInterface');

        $path = $this->getPath($name, TRUE);

        if ($this->files->exists($path)) {
            $this->error($this->type . ' interface already exists!');
            return FALSE;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildInterfaceClass($name));

        $this->info($this->type . ' interface created successfully.');

        $this->registerToServiceProvider();
    }

    protected function buildInterfaceClass($name)
    {
        $stub = $this->files->get(__DIR__ . '/stubs/repository.interface.stub');

        $formattedName = $this->getFormattedName();

        // 替換命名空間
        $stub = str_replace('DummyNamespace', $formattedName, $stub);

        // 替換接口名稱
        $stub = str_replace('DummyClassRepositoryInterface', $formattedName . 'RepositoryInterface', $stub);

        return $stub;
    }

    // 將 Repository 與其 Interface 註冊到 RepositoryServiceProvider 中
    protected function registerToServiceProvider()
    {
        $repoShortName = $this->getFormattedName() . 'Repository';
        $interfaceShortName = $this->getFormattedName() . 'RepositoryInterface';
        $repoNamespace = $this->getDefaultNamespace($this->laravel->getNamespace()) . '\\' . $this->getFormattedName() . '\\' . $repoShortName;
        $interfaceNamespace = $this->getDefaultNamespace($this->laravel->getNamespace()) . '\\' . $this->getFormattedName() . '\\' . $interfaceShortName;

        $serviceProviderPath = $this->laravel['path'] . '/Providers/RepositoryServiceProvider.php';

        $content = $this->files->get($serviceProviderPath);

        $useStatements = "use {$interfaceNamespace};\nuse {$repoNamespace};";
        if (!str_contains($content, "use {$interfaceNamespace};")) {
            $content = preg_replace('/(namespace YFDev\System\App\\\\Providers;)/', "$1\n{$useStatements}", $content);
        }

        $newBinding = "\$this->app->bind(\n            {$interfaceShortName}::class,\n            {$repoShortName}::class\n        );\n";
        if (!str_contains($content, $newBinding)) {
            $content = preg_replace('/(public function register\(\)[\s\S]*?\{)/', "$1\n        {$newBinding}", $content);
        }

        $this->files->put($serviceProviderPath, $content);
    }
}
