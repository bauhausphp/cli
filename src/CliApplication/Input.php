<?php

namespace Bauhaus\CliApplication;

final class Input
{
    private array $rawInput;
    private CommandId $commandId;

    private function __construct(
        string ...$rawInput,
    ) {
        $this->rawInput = $rawInput;
        $this->parseInput();
    }

    public static function fromGlobal(): self
    {
        return new self(...$_SERVER['argv']);
    }

    public static function fromString(string $rawInput): self
    {
        return new self(...explode(' ', $rawInput));
    }

    public function commandId(): CommandId
    {
        return $this->commandId;
    }

    private function parseInput(): void
    {
        $this->commandId = new CommandId($this->rawInput[1]);
    }
}
