<?php

namespace Bauhaus\CliApplication\Processor;

use Bauhaus\CliApplication\CommandCollection;
use Bauhaus\CliApplication\Processor;
use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class EntrypointExecutor implements Processor
{
    private CommandCollection $commands;

    public function __construct(CliEntrypoint ...$entrypoints)
    {
        $this->commands = CommandCollection::fromEntrypoints(...$entrypoints);
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $command = $this->commands->findMatch($input);

        $command->execute($input, $output);
    }
}
