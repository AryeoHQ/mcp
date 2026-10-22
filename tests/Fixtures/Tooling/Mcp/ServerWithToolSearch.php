<?php

declare(strict_types=1);

namespace Tests\Fixtures\Tooling\Mcp;

use Laravel\Mcp\Server\Tools\ToolSearch;
use Support\Mcp\Servers\Server;
use Tests\Fixtures\Support\Mcp\SearchTickets;

class ServerWithToolSearch extends Server
{
    protected array $tools = [
        ToolSearch::class => [SearchTickets::class],
    ];

    protected function boot(): void
    {
        $this->tools = new ToolSearch([SearchTickets::class])->tools();
    }
}
