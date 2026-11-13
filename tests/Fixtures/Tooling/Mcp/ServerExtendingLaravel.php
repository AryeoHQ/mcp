<?php

declare(strict_types=1);

namespace Tests\Fixtures\Tooling\Mcp;

use Laravel\Mcp\Server;

class ServerExtendingLaravel extends Server
{
    protected string $name = 'Support';
}
