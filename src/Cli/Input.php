<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Attribute\Name;

final class Input
{
    private array $argv;
    private Name $commandName;

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

    public function commandName(): Name
    {
        return $this->commandName;
    }

    private function parseInput(): void
    {
        $this->commandName = new Name($this->argv[1]);
    }
}
