<?php

declare(strict_types=1);

namespace Mcp\Servers\Registrar;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures\Mcp\SearchTickets;
use Tests\Fixtures\Mcp\Support;
use Tests\TestCase;

class RegistrarTest extends TestCase
{
    #[Test]
    public function it_registers_a_primitive_for_a_server(): void
    {
        $registrar = new Registrar;

        $registrar->register(Support::class, SearchTickets::class);

        $this->assertSame(
            [SearchTickets::class],
            $registrar->for(Support::class),
        );
    }

    #[Test]
    public function it_throws_for_an_unsupported_primitive(): void
    {
        $registrar = new Registrar;

        $this->expectException(InvalidArgumentException::class);

        $registrar->register(Support::class, self::class); // @phpstan-ignore argument.type (intentionally passing an unsupported type to assert the runtime guard)
    }

    #[Test]
    public function it_returns_the_registrar_for_chaining(): void
    {
        $registrar = new Registrar;

        $this->assertSame(
            $registrar,
            $registrar->register(Support::class, SearchTickets::class),
        );
    }

    #[Test]
    public function it_returns_an_empty_array_for_an_unknown_server(): void
    {
        $registrar = new Registrar;

        $this->assertSame([], $registrar->for(Support::class));
    }

    #[Test]
    public function it_keeps_registrations_separated_by_server(): void
    {
        $registrar = new Registrar;

        $registrar->register(Support::class, SearchTickets::class);

        $this->assertSame([SearchTickets::class], $registrar->for(Support::class));
        $this->assertSame([], $registrar->for(self::class));
    }
}
