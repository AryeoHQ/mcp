<?php

declare(strict_types=1);

namespace Tests\Fixtures\Mcp;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

class DraftReply extends Prompt
{
    public function handle(Request $request): Response
    {
        return Response::text('example');
    }
}
