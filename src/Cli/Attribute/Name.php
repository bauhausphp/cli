<?php

namespace Bauhaus\Cli\Attribute;

use Attribute;

#[Attribute]
final class Name
{
    public function __construct(
        private string $value,
    ) {
        $this->assertIsValid();
    }

    public function equalTo(self $that): bool
    {
        return $this->value === $that->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function assertIsValid(): void
    {
        $alphaNumeric = 'A-Za-z0-9';
        $allowed = "$alphaNumeric-_";
        $word = "[$alphaNumeric][$allowed]*";

        if (0 === preg_match("/^$word(:$word)*$/", $this->value)) {
            throw new InvalidArgument($this->value);
        }
    }
}
