<?php

namespace Bauhaus\CliApplication;

/**
 * @internal
 */
final class Command
{
    private CommandId $id;

    private function __construct(
        private string $entrypointClass,
    ) {
        // TODO check if it is CommandEntrypoint class

        $this->extractEntrypointAttributes();
    }

    public static function fromEntrypoint(string $entrypointClass): self
    {
        return new self($entrypointClass);
    }

    public function id(): CommandId
    {
        return $this->id;
    }

    public function match(Input $input): bool
    {
        return $this->id->equalTo($input->commandId());
    }

    private function extractEntrypointAttributes(): void
    {
        $attributeExtractor = new CommandAttributeExtractor($this->entrypointClass);

        $this->id = $attributeExtractor->id();
    }
}
