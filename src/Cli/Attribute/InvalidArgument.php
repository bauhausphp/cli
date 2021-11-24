<?php

namespace Bauhaus\Cli\Attribute;

use InvalidArgumentException;

final class InvalidArgument extends InvalidArgumentException
{
    public function __construct(string $invalid)
    {
        parent::__construct("Invalid cli argument: '$invalid'");
    }
}
