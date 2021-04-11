<?php

namespace Bauhaus\CliApplication\Output;

use RuntimeException;

final class CannotWrite extends RuntimeException
{
    public function __construct(string $message, string $output)
    {
        parent::__construct("$message: $output");
    }

    public static function toDirectory(string $output): self
    {
        return new self('Provided output is a directory', $output);
    }
}
