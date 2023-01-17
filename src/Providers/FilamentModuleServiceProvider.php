<?php

namespace Sorethea\FilamentModule\Providers;

use Illuminate\Support\ServiceProvider;
use Sorethea\FilamentModule\Commands\FilamentPageMakeCommand;
use Sorethea\FilamentModule\Commands\FilamentProviderMakeCommand;
use Sorethea\FilamentModule\Commands\ModuleMakeCommand;
use Sorethea\FilamentModule\Commands\ProviderMakeCommand;

class FilamentModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            ModuleMakeCommand::class,
            ProviderMakeCommand::class,
            FilamentProviderMakeCommand::class,
            FilamentPageMakeCommand::class,
        ]);

    }

    public function boot()
    {
        $this->registerConfig();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__."/../Config/config.php"=> config_path('filament-modules' . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__."/../Config/config.php", 'filament-modules'
        );
    }
}
