<?php

namespace Bauhaus;

use Bauhaus\Cli\CommandId;

final class CliInput
{
    private array $argv;
    private CommandId $commandId;

    private function __construct(string ...$rawInput)
    {
        $this->argv = $rawInput;
        $this->parseInput();
    }

    public static function fromArgv(string ...$argv): self
    {
        return new self(...$argv);
    }

    public static function fromString(string $string): self
    {
        return new self(...explode(' ', $string));
    }

    public function commandId(): CommandId
    {
        return $this->commandId;
    }

    private function parseInput(): void
    {
        $this->commandId = new CommandId($this->argv[1]);
    }
}
