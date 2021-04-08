<?php

namespace Bauhaus\CliApplication;

use Attribute;

#[Attribute]
final class CommandId
{
    public function __construct(
        private string $value,
    ) {
    }

    public function equalTo(self $that): bool
    {
        return $this->value === $that->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
