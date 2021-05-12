<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\Cli\Command;
use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\Input;

/**
 * @internal
 */
final class CommandCollection
{
    private array $commands;

    private function __construct(Command ...$commands)
    {
        $this->commands = $commands;
    }

    public static function fromEntrypoints(Entrypoint ...$entrypoints): self
    {
        $commands = array_map(
            fn (Entrypoint $e) => Command::fromEntrypoint($e),
            $entrypoints,
        );

        return new self(...$commands);
    }

    public function findMatch(Input $input): ?Command
    {
        foreach ($this->commands as $command) {
            if ($command->match($input)) {
                return $command;
            }
        }

        return null;
    }
}
