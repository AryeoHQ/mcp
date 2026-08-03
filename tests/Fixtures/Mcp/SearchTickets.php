<?php

declare(strict_types=1);

namespace Tests\Fixtures\Mcp;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class SearchTickets extends Tool
{
    public function handle(Request $request): Response
    {
        return Response::text('example');
    }
}
