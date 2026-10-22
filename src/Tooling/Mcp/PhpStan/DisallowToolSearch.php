<?php

declare(strict_types=1);

namespace Tooling\Mcp\PhpStan;

use Laravel\Mcp\Server\Tools\ToolSearch;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\New_;
use PHPStan\Analyser\Scope;
use Tooling\PhpStan\Rules\Rule;
use Tooling\Rules\Attributes\NodeType;

/**
 * @extends \Tooling\PhpStan\Rules\Rule<\PhpParser\Node\Expr>
 */
#[NodeType(Node\Expr::class)]
final class DisallowToolSearch extends Rule
{
    public const string DISALLOWED = ToolSearch::class; // @phpstan-ignore mcp.Server.ToolSearch.notAllowed (the rule has to name the class it disallows)

    public function shouldHandle(Node $node, Scope $scope): bool
    {
        if (! ($node instanceof ClassConstFetch || $node instanceof New_) || ! $node->class instanceof Node\Name) {
            return false;
        }

        return strcasecmp($scope->resolveName($node->class), self::DISALLOWED) === 0;
    }

    public function handle(Node $node, Scope $scope): void
    {
        $toolSearch = class_basename(self::DISALLOWED);

        $this->error(
            message: "Don't use `{$toolSearch}`. Grouping tools is the harness's job, and harnesses like VS Code and Claude Code already do it. `{$toolSearch}` hides every tool behind `search_tools` and `execute_tools`, so no one can reference a tool directly in chat, skills, or agent instructions.",
            line: $node->getStartLine(),
            identifier: 'mcp.Server.ToolSearch.notAllowed'
        );
    }
}
