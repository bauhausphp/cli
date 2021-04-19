<?php

namespace Bauhaus\Cli;

use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;
use RuntimeException;
use Throwable;

/**
 * @internal
 */
final class EntrypointCouldNotBeLoaded extends RuntimeException
{
    private function __construct(string $msg, string $class, Throwable $reason)
    {
        $msg = "Could not load entrypoint ($msg) - $class";

        parent::__construct(message: $msg, previous: $reason);
    }

    public static function notFound(string $class, PsrNotFoundException $reason): self
    {
        return new self('not found', $class, $reason);
    }

    public static function error(string $class, Throwable $reason): self
    {
        return new self('generic error', $class, $reason);
    }
}
