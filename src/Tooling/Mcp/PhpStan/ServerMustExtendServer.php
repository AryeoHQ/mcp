<?php

declare(strict_types=1);

namespace Tooling\Mcp\PhpStan;

use Laravel\Mcp;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use Support\Mcp\Servers\Server;
use Tooling\PhpStan\Rules\Rule;
use Tooling\Rules\Attributes\NodeType;

/**
 * @extends \Tooling\PhpStan\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
#[NodeType(Class_::class)]
final class ServerMustExtendServer extends Rule
{
    /**
     * @param  \PhpParser\Node\Stmt\Class_  $node
     */
    public function shouldHandle(Node $node, Scope $scope): bool
    {
        return $node->namespacedName?->toString() !== Server::class
            && $this->inherits($node, Mcp\Server::class)
            && $this->doesNotInherit($node, Server::class);
    }

    /**
     * @param  \PhpParser\Node\Stmt\Class_  $node
     */
    public function handle(Node $node, Scope $scope): void
    {
        $this->error(
            message: 'MCP servers must extend '.Server::class.' instead of '.Mcp\Server::class.', so packages can add() tools, resources, and prompts to them.',
            line: $node->extends?->getStartLine() ?? $node->getStartLine(),
            identifier: 'mcp.Server.Server.required'
        );
    }
}
