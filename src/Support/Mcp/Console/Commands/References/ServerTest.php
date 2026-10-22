<?php

declare(strict_types=1);

namespace Support\Mcp\Console\Commands\References;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;
use Tooling\GeneratorCommands\References\Contracts\Reference;
use Tooling\GeneratorCommands\References\ReferenceTestCases;
use Tooling\GeneratorCommands\Testing\Contracts\TestsReference;

#[CoversClass(Server::class)]
class ServerTest extends TestCase implements TestsReference
{
    use ReferenceTestCases;

    public Reference $subject {
        get => new Server(name: 'Support', baseNamespace: 'Tests');
    }

    public string $expectedName = 'Support';
}
