<?php

declare(strict_types=1);

namespace Tooling\Mcp\Rector;

use Laravel\Mcp;
use PhpParser\Node\Stmt\Class_;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Support\Mcp\Servers\Server;
use Tests\TestCase;
use Tests\Tooling\Concerns\GetsFixtures;
use Tooling\Rector\Testing\ParsesNodes;
use Tooling\Rector\Testing\ResolvesRectorRules;

class ServerMustExtendServerTest extends TestCase
{
    use GetsFixtures;
    use ParsesNodes;
    use ResolvesRectorRules;

    #[Test]
    public function it_has_rule_definition(): void
    {
        $this->assertSame(
            'Extend '.Server::class.' instead of '.Mcp\Server::class,
            $this->resolveRule(ServerMustExtendServer::class)->getRuleDefinition()->getDescription(),
        );
    }

    #[Test]
    public function it_swaps_laravels_server_for_ours(): void
    {
        $classNode = $this->getClassNode($this->getFixturePath('Mcp/ServerExtendingLaravel.php'));

        $result = $this->resolveRule(ServerMustExtendServer::class)->refactor($classNode);

        $this->assertInstanceOf(Class_::class, $result);
        $this->assertSame(Server::class, $result->extends?->toString());
    }

    #[Test]
    public function it_skips_our_own_server(): void
    {
        $classNode = $this->getClassNode((string) new ReflectionClass(Server::class)->getFileName());

        $this->assertNull($this->resolveRule(ServerMustExtendServer::class)->refactor($classNode));
    }

    #[Test]
    public function it_skips_a_server_that_already_extends_ours(): void
    {
        $classNode = $this->getClassNode($this->getFixturePath('Mcp/ValidServer.php'));

        $this->assertNull($this->resolveRule(ServerMustExtendServer::class)->refactor($classNode));
    }
}
