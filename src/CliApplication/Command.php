<?php

namespace Bauhaus\CliApplication;

use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
final class Command
{
    private CommandId $id;

    private function __construct(
        private CliEntrypoint $entrypoint,
    ) {
        // TODO check if it is CommandEntrypoint class

        $this->extractEntrypointAttributes();
    }

    public static function fromEntrypoint(CliEntrypoint $entrypoint): self
    {
        return new self($entrypoint);
    }

    public function id(): CommandId
    {
        return $this->id;
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->entrypoint->execute($input, $output);
    }

    public function match(CliInput $input): bool
    {
        return $this->id->equalTo($input->commandId());
    }

    private function extractEntrypointAttributes(): void
    {
        $attributeExtractor = new CommandAttributeExtractor($this->entrypoint);

        $this->id = $attributeExtractor->id();
    }
}
