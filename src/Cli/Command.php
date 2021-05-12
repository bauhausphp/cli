<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Attribute\Extractor;
use Bauhaus\Cli\Attribute\Name;

/**
 * @internal
 */
final class Command
{
    private Name $id;

    private function __construct(
        private Entrypoint $entrypoint,
    ) {
        $this->extractEntrypointAttributes();
    }

    public static function fromEntrypoint(Entrypoint $entrypoint): self
    {
        return new self($entrypoint);
    }

    public function id(): Name
    {
        return $this->id;
    }

    public function execute(Input $input, Output $output): void
    {
        $this->entrypoint->execute($input, $output);
    }

    public function match(Input $input): bool
    {
        return $this->id->equalTo($input->commandName());
    }

    private function extractEntrypointAttributes(): void
    {
        $attributeExtractor = new Extractor($this->entrypoint);

        $this->id = $attributeExtractor->id();
    }
}
