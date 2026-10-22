<?php

declare(strict_types=1);

namespace Tests;

use Support\Mcp\Providers\Provider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $enablesPackageDiscoveries = true;

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            Provider::class,
        ];
    }
}
