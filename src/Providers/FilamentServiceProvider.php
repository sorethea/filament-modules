<?php

namespace Sorethea\Filament\Providers;

use Illuminate\Support\ServiceProvider;
use Sorethea\Filament\Commands\FilamentPageMakeCommand;
use Sorethea\Filament\Commands\FilamentProviderMakeCommand;
use Sorethea\Filament\Commands\FilamentResourceMakeCommand;
use Sorethea\Filament\Commands\ModuleMakeCommand;
use Sorethea\Filament\Commands\ProviderMakeCommand;

class FilamentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            ModuleMakeCommand::class,
            ProviderMakeCommand::class,
            FilamentProviderMakeCommand::class,
            FilamentPageMakeCommand::class,
            FilamentResourceMakeCommand::class,
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
