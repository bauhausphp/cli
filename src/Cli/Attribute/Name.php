<?php

namespace Bauhaus\Cli\Attribute;

use Attribute;

#[Attribute]
final class Name
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
