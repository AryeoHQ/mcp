<?php

declare(strict_types=1);

namespace Tooling\Mcp\PhpStan;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Tooling\Concerns\GetsFixtures;

/**
 * @extends \PHPStan\Testing\RuleTestCase<\Tooling\Mcp\PhpStan\DisallowToolSearch>
 */
class DisallowToolSearchTest extends RuleTestCase
{
    use GetsFixtures;

    protected function getRule(): Rule
    {
        return new DisallowToolSearch;
    }

    #[Test]
    public function it_passes_without_tool_search(): void
    {
        $this->analyse([$this->getFixturePath('Mcp/ValidServer.php')], []);
    }

    #[Test]
    public function it_fails_when_using_tool_search(): void
    {
        $toolSearch = class_basename(DisallowToolSearch::DISALLOWED);
        $message = "Don't use `{$toolSearch}`. Grouping tools is the harness's job, and harnesses like VS Code and Claude Code already do it. `{$toolSearch}` hides every tool behind `search_tools` and `execute_tools`, so no one can reference a tool directly in chat, skills, or agent instructions.";

        $this->analyse([$this->getFixturePath('Mcp/ServerWithToolSearch.php')], [
            [$message, 14],
            [$message, 19],
        ]);
    }
}
