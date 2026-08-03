<?php

declare(strict_types=1);

namespace Mcp;

use Illuminate\Support\ServiceProvider;
use Mcp\Servers\Registrar\Registrar;

class Provider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerMcp();
    }

    private function registerMcp(): void
    {
        $this->app->singleton(Registrar::class, fn (): Registrar => new Registrar);
    }
}
