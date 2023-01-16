<?php

namespace Sorethea\FilamentModule\Providers;

use Illuminate\Support\ServiceProvider;
use Sorethea\FilamentModule\Commands\ModuleMakeCommand;

class FilamentModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            ModuleMakeCommand::class,
        ]);

    }

    public function boot()
    {

    }
}
