<?php

namespace Bauhaus\Cli\PsrContainer;

use RuntimeException;
use Throwable;

/**
 * @internal
 */
final class CouldNotLoadFromPsrContainer extends RuntimeException
{
    public function __construct(string $class, Throwable $reason)
    {
        $msg = <<<MSG
            Could not load service from PSR container
                id: $class
                reason: {$reason->getMessage()}
            MSG;

        parent::__construct(message: $msg, previous: $reason);
    }
}
