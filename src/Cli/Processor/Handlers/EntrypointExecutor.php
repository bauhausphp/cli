<?php

namespace Bauhaus\Cli\Processor\Handlers;

use Bauhaus\Cli\CommandCollection;
use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class EntrypointExecutor implements Handler
{
    public function __construct(
        private CommandCollection $commands,
    ) {
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $command = $this->commands->findMatch($input);

        $command->execute($input, $output);
    }
}
