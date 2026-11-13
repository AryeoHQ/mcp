<?php

declare(strict_types=1);

namespace Support\Mcp\Console\Commands\References;

use Illuminate\Support\Stringable;
use Tooling\GeneratorCommands\References\GenericClass;

final class Server extends GenericClass
{
    public null|Stringable $subNamespace {
        get => str('Mcp\\Servers');
    }

    public Stringable $stubPath {
        get => str(__DIR__.'/stubs/server.stub');
    }
}
