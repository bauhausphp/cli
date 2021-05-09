<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Attribute\Name;

final class Input
{
    private array $argv;
    private Name $commandId;

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

    public function commandId(): Name
    {
        return $this->commandId;
    }

    private function parseInput(): void
    {
        $this->commandId = new Name($this->argv[1]);
    }
}
