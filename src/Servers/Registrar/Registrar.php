<?php

declare(strict_types=1);

namespace Mcp\Servers\Registrar;

use InvalidArgumentException;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Resource;
use Laravel\Mcp\Server\Tool;

class Registrar
{
    /** @var array<string, array<class-string<\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool>|\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool>> */
    public private(set) array $registrations = [];

    /**
     * @param  class-string<\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool>|\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool  $primitive
     */
    public function register(string $server, string|Prompt|Resource|Tool $primitive): static
    {
        throw_unless(
            is_a($primitive, Prompt::class, true) || is_a($primitive, Resource::class, true) || is_a($primitive, Tool::class, true),
            InvalidArgumentException::class,
            class_basename($primitive).' must be a '.class_basename(Prompt::class).', '.class_basename(Resource::class).', or '.class_basename(Tool::class).'.'
        );

        $this->registrations[$server][] = $primitive;

        return $this;
    }

    /**
     * @return array<array-key, class-string<\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool>|\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool>
     */
    public function for(string $server): array
    {
        return $this->registrations[$server] ?? [];
    }
}
