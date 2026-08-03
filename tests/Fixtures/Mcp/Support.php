<?php

declare(strict_types=1);

namespace Tests\Fixtures\Mcp;

use Mcp\Servers\Server;

class Support extends Server
{
    protected string $name = 'Support';

    protected string $version = '0.0.1';

    protected string $instructions = 'Provides customer support tooling.';
}
