<?php

declare(strict_types=1);

namespace Support\Mcp\Console\Commands;

use Illuminate\Support\Stringable;
use Laravel\Mcp;
use Support\Mcp\Console\Commands\References\Server;
use Symfony\Component\Console\Input\InputOption;
use Tooling\GeneratorCommands\Concerns\CreatesColocatedTests;
use Tooling\GeneratorCommands\Concerns\GeneratorCommandCompatibility;
use Tooling\GeneratorCommands\Concerns\RetrievesNamespace;
use Tooling\GeneratorCommands\Contracts\GeneratesFile;

class MakeServerCommand extends Mcp\Console\Commands\MakeServerCommand implements GeneratesFile
{
    use CreatesColocatedTests;
    use GeneratorCommandCompatibility;
    use RetrievesNamespace;

    protected $name = 'make:mcp-server';

    protected $description = 'Create a new MCP server class';

    public Stringable $nameInput {
        get => $this->nameInput ??= str($this->argument('name'));
    }

    public Server $reference {
        get => $this->reference ??= resolve(Server::class, [
            'name' => $this->nameInput,
            'baseNamespace' => $this->baseNamespace,
        ]);
    }

    public function handle(): null|bool
    {
        $this->resolveNamespace();

        return parent::handle();
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->rootNamespace();
    }

    /** @return array<int, InputOption> */
    protected function getOptions(): array // @phpstan-ignore method.childReturnType
    {
        return [
            new InputOption('force', 'f', InputOption::VALUE_NONE, 'Create the class even if the server already exists'),
            ...$this->getNamespaceInputOptions(),
        ];
    }
}
