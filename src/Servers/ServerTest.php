<?php

declare(strict_types=1);

namespace Mcp\Servers;

use Laravel\Mcp\Facades\Mcp;
use Mcp\Servers\Registrar\Registrar;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures\Mcp\DraftReply;
use Tests\Fixtures\Mcp\KnowledgeBase;
use Tests\Fixtures\Mcp\SearchTickets;
use Tests\Fixtures\Mcp\Support;
use Tests\TestCase;

class ServerTest extends TestCase
{
    #[Test]
    public function add_registers_a_primitive_for_the_server(): void
    {
        Support::add(SearchTickets::class);

        $this->assertSame(
            [SearchTickets::class],
            resolve(Registrar::class)->for(Support::class),
        );
    }

    #[Test]
    public function add_accepts_multiple_primitives(): void
    {
        Support::add(SearchTickets::class, KnowledgeBase::class, DraftReply::class);

        $this->assertSame(
            [SearchTickets::class, KnowledgeBase::class, DraftReply::class],
            resolve(Registrar::class)->for(Support::class),
        );
    }

    #[Test]
    public function start_registers_each_primitive_by_type(): void
    {
        Support::add(SearchTickets::class, KnowledgeBase::class, DraftReply::class);

        Support::tool(SearchTickets::class)->assertOk();
        Support::resource(KnowledgeBase::class)->assertOk();
        Support::prompt(DraftReply::class)->assertOk();
    }

    #[Test]
    public function local_registers_the_server_using_the_kebab_cased_class_basename(): void
    {
        Support::local();

        $this->assertNotNull(
            Mcp::getLocalServer('support'),
        );
    }

    #[Test]
    public function local_accepts_an_explicit_handle(): void
    {
        Support::local('custom-handle');

        $this->assertNotNull(
            Mcp::getLocalServer('custom-handle'),
        );
    }

    #[Test]
    public function web_registers_the_server_using_the_kebab_cased_class_basename(): void
    {
        $route = Support::web();

        $this->assertSame('support', $route->uri());
    }

    #[Test]
    public function web_accepts_an_explicit_route(): void
    {
        $route = Support::web('custom-route');

        $this->assertSame('custom-route', $route->uri());
    }
}
