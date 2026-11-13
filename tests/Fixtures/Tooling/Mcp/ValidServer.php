<?php

declare(strict_types=1);

namespace Tests\Fixtures\Tooling\Mcp;

use Support\Mcp\Servers\Server;
use Tests\Fixtures\Support\Mcp\SearchTickets;

class ValidServer extends Server
{
    protected array $tools = [
        SearchTickets::class,
    ];
}
