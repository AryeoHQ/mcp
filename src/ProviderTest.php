<?php

declare(strict_types=1);

namespace Mcp;

use Mcp\Servers\Registrar\Registrar;
use PHPUnit\Framework\Attributes\Test;
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
}
