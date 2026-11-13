<?php

declare(strict_types=1);

namespace Support\Mcp\Providers;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\Attributes\Test;
use Support\Mcp\Console\Commands\MakeServerCommand;
use Support\Mcp\Servers\Registrar\Registrar;
use Tests\TestCase;

class ProviderTest extends TestCase
{
    #[Test]
    public function it_binds_the_registrar_as_a_singleton(): void
    {
        $this->assertSame(
            resolve(Registrar::class),
            resolve(Registrar::class),
        );
    }

    #[Test]
    public function it_overrides_make_mcp_server(): void
    {
        $this->assertInstanceOf(
            MakeServerCommand::class,
            resolve(Kernel::class)->all()['make:mcp-server'],
        );
    }
}
