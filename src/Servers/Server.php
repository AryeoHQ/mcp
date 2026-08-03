<?php

declare(strict_types=1);

namespace Mcp\Servers;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Laravel\Mcp\Facades\Mcp;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Resource;
use Laravel\Mcp\Server\Tool;
use Mcp\Servers\Registrar\Registrar;

class Server extends \Laravel\Mcp\Server
{
    public Registrar $registrar { get => resolve(Registrar::class); }

    /**
     * @param  class-string<\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool>|\Laravel\Mcp\Server\Prompt|\Laravel\Mcp\Server\Resource|\Laravel\Mcp\Server\Tool  ...$primitives
     */
    final public static function add(string|Prompt|Resource|Tool ...$primitives): void
    {
        collect($primitives)->each(
            fn (string|Prompt|Resource|Tool $primitive): Registrar => resolve(Registrar::class)->register(static::class, $primitive)
        );
    }

    final public static function local(null|string $handle = null): void
    {
        Mcp::local($handle ?? static::guessHandle(), static::class);
    }

    final public static function web(null|string $route = null): Route
    {
        return Mcp::web($route ?? static::guessHandle(), static::class);
    }

    protected static function guessHandle(): string
    {
        return Str::kebab(class_basename(static::class));
    }

    final public function start(): void
    {
        collect($this->registrar->for(static::class))->each(function (string|Prompt|Resource|Tool $primitive): void {
            match (true) {
                is_a($primitive, Tool::class, true) => $this->tools[] = $primitive,
                is_a($primitive, Resource::class, true) => $this->resources[] = $primitive,
                is_a($primitive, Prompt::class, true) => $this->prompts[] = $primitive,
                default => null,
            };
        });

        parent::start();
    }
}
