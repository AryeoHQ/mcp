<?php

declare(strict_types=1);

namespace Support\Mcp\Providers;

use Illuminate\Support\ServiceProvider;
use Support\Mcp\Console\Commands\MakeServerCommand;
use Support\Mcp\Servers\Registrar\Registrar;

class Provider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerMcp();
    }

    public function boot(): void
    {
        $this->bootCommands();
        $this->bootViews();
    }

    private function registerMcp(): void
    {
        $this->app->singleton(Registrar::class, fn (): Registrar => new Registrar);
    }

    private function bootCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MakeServerCommand::class,
        ]);
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../../../resources/views/rector/rules', 'mcp.rector.rules.samples');
    }
}
