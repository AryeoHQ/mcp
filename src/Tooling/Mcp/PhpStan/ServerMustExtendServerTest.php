<?php

declare(strict_types=1);

namespace Tooling\Mcp\PhpStan;

use Laravel\Mcp;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Support\Mcp\Servers\Server;
use Tests\Tooling\Concerns\GetsFixtures;

/**
 * @extends \PHPStan\Testing\RuleTestCase<\Tooling\Mcp\PhpStan\ServerMustExtendServer>
 */
class ServerMustExtendServerTest extends RuleTestCase
{
    use GetsFixtures;

    protected function getRule(): Rule
    {
        return new ServerMustExtendServer;
    }

    #[Test]
    public function it_passes_when_server_extends_our_server(): void
    {
        $this->analyse([$this->getFixturePath('Mcp/ValidServer.php')], []);
    }

    #[Test]
    public function it_passes_for_our_own_server(): void
    {
        $this->analyse([(string) new ReflectionClass(Server::class)->getFileName()], []);
    }

    #[Test]
    public function it_fails_when_server_extends_laravels_server(): void
    {
        $this->analyse([$this->getFixturePath('Mcp/ServerExtendingLaravel.php')], [
            [
                'MCP servers must extend '.Server::class.' instead of '.Mcp\Server::class.', so packages can add() tools, resources, and prompts to them.',
                9,
            ],
        ]);
    }
}
