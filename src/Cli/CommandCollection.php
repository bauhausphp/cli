<?php

namespace Bauhaus\Cli;

use ArrayIterator;
use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use IteratorAggregate;

/**
 * @internal
 */
final class CommandCollection implements IteratorAggregate
{
    private array $commands;

    private function __construct(Command ...$commands)
    {
        $this->commands = $commands;

        $this->sort();
    }

    public static function fromEntrypoints(CliEntrypoint ...$entrypoints): self
    {
        $commands = array_map(
            fn (CliEntrypoint $e) => Command::fromEntrypoint($e),
            $entrypoints,
        );

        return new self(...$commands);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->commands);
    }

    public function findMatch(CliInput $input): ?Command
    {
        foreach ($this->commands as $command) {
            if ($command->match($input)) {
                return $command;
            }
        }

        return null;
    }

    private function sort(): void
    {
        usort(
            $this->commands,
            fn (Command $a, Command $b) => strcmp($a->id(), $b->id()),
        );
    }
}
