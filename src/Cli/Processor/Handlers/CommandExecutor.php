<?php

namespace Bauhaus\Cli\Processor\Handlers;

use Bauhaus\Cli\Processor\CommandCollection;
use Bauhaus\Cli\Processor\Handler;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

/**
 * @internal
 */
final class CommandExecutor implements Handler
{
    public function __construct(
        private CommandCollection $commands,
    ) {
    }

    public function execute(Input $input, Output $output): void
    {
        $command = $this->commands->findMatch($input);

        $command->execute($input, $output);
    }
}
