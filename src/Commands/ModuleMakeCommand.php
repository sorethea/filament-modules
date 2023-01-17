<?php

namespace Sorethea\FilamentModule\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Sorethea\FilamentModule\Generators\ModuleGenerator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'module:make-filament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new laravel filament module.';
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $names = $this->argument('name');
        $success = true;
        foreach ($names as $name) {
            $code = with(new ModuleGenerator($name))
                ->setFilesystem($this->laravel['files'])
                ->setModule($this->laravel['modules'])
                ->setConfig($this->laravel['config'])
                ->setActivator($this->laravel[ActivatorInterface::class])
                ->setConsole($this)
                ->setComponent($this->components)
                ->setForce($this->option('force'))
                ->setType($this->getModuleType())
                ->setActive(!$this->option('disabled'))
                ->generate();

            if ($code === E_ERROR) {
                $success = false;
            }
        }

        return $success ? 0 : E_ERROR;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The names of modules will be created.'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain module (without some resources).'],
            ['filament', null, InputOption::VALUE_NONE, 'Generate a laravel filament module.'],
            ['api', null, InputOption::VALUE_NONE, 'Generate an api module.'],
            ['web', null, InputOption::VALUE_NONE, 'Generate a web module.'],
            ['disabled', 'd', InputOption::VALUE_NONE, 'Do not enable the module at creation.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when the module already exists.'],
        ];
    }

    /**
     * Get module type .
     *
     * @return string
     */
    private function getModuleType()
    {
        $isPlain = $this->option('plain');
        $isApi = $this->option('api');
        $isFilament = $this->options('filament');

        if ($isPlain && $isApi) {
            return 'web';
        }
        if ($isPlain) {
            return 'plain';
        } elseif ($isApi) {
            return 'api';
        } elseif ($isFilament) {
            return 'filament';
        } else {
            return 'web';
        }
    }

}
