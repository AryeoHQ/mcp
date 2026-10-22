<?php

declare(strict_types=1);

namespace Support\Mcp\Console\Commands;

use Illuminate\Support\Facades\File;
use Laravel\Mcp;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Support\Mcp\Servers\Server;
use Tests\TestCase;
use Tooling\Composer\Composer;
use Tooling\GeneratorCommands\References\Contracts\Reference;
use Tooling\GeneratorCommands\Testing\Concerns\GeneratesFileTestCases;
use Tooling\GeneratorCommands\Testing\Concerns\RetrievesNamespaceTestCases;

#[CoversClass(MakeServerCommand::class)]
class MakeServerCommandTest extends TestCase
{
    use GeneratesFileTestCases;
    use RetrievesNamespaceTestCases;

    public References\Server $reference {
        get => new References\Server(name: 'Support', baseNamespace: 'App');
    }

    private Reference $nestedReference {
        get => new References\Server(name: 'Support', baseNamespace: 'App\\Nested\\Deeper');
    }

    /** @var array<string, mixed> */
    public array $baselineInput {
        get => ['name' => 'Support', '--namespace' => 'App\\'];
    }

    /** @var array<string, mixed> */
    public array $withNamespaceBackslashInput {
        get => $this->baselineInput;
    }

    /** @var array<string, mixed> */
    public array $withoutNamespaceBackslashInput {
        get => ['name' => 'Support', '--namespace' => 'App'];
    }

    /** @var array<string, mixed> */
    public array $withNestedNamespaceInput {
        get => ['name' => 'Support', '--namespace' => 'App\\Nested\\Deeper'];
    }

    protected string $expectedNestedFilePath {
        get => $this->nestedReference->filePath->toString();
    }

    #[Test]
    public function it_generates_a_server_that_extends_our_server(): void
    {
        Composer::fake();

        $this->artisan($this->command, $this->baselineInput)->assertSuccessful();

        $file = File::get($this->expectedFilePath);

        $this->assertStringContainsString('use '.Server::class.';', $file);
        $this->assertStringContainsString('class Support extends Server', $file);
        $this->assertStringNotContainsString('use '.Mcp\Server::class.';', $file);
        $this->assertStringContainsString("#[Name('Support')]", $file);
    }

    #[Test]
    public function it_generates_a_co_located_test(): void
    {
        Composer::fake();

        $this->artisan($this->command, $this->baselineInput)->assertSuccessful();

        $this->assertTrue(File::exists($this->reference->test->filePath->toString()));
    }
}
