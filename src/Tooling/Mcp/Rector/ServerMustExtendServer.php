<?php

declare(strict_types=1);

namespace Tooling\Mcp\Rector;

use Laravel\Mcp;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use Support\Mcp\Servers\Server;
use Tooling\Rector\Rules\Definitions\Attributes\Definition;
use Tooling\Rector\Rules\Rule;
use Tooling\Rector\Rules\Samples\Attributes\Sample;
use Tooling\Rules\Attributes\NodeType;

/**
 * @extends \Tooling\Rector\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
#[Definition('Extend '.Server::class.' instead of '.Mcp\Server::class)]
#[NodeType(Class_::class)]
#[Sample('mcp.rector.rules.samples')]
final class ServerMustExtendServer extends Rule
{
    /**
     * @param  \PhpParser\Node\Stmt\Class_  $node
     */
    public function shouldHandle(Node $node): bool
    {
        return $node->extends !== null
            && $this->isName($node->extends, Mcp\Server::class)
            && ! $this->isName($node, Server::class);
    }

    /**
     * @param  \PhpParser\Node\Stmt\Class_  $node
     */
    public function handle(Node $node): Node
    {
        $node->extends = new FullyQualified(Server::class);

        return $node;
    }
}
