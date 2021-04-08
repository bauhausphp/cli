<?php

namespace Bauhaus\CliApplication;

use ArrayIterator;
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

    public static function fromEntrypoints(string ...$entrypoints): self
    {
        $commands = array_map(
            fn (string $e) => Command::fromEntrypoint($e),
            $entrypoints,
        );

        return new self(...$commands);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->commands);
    }

    public function findMatchingCommand(Input $input): ?Command
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
