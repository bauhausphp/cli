<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\CliInput;
use Bauhaus\CliApplication\Middleware\Middleware;
use Bauhaus\CliApplication\Middleware\MiddlewareHandler;
use Bauhaus\CliOutput;

class MiddlewareThatWritesInOutput implements Middleware
{
    public function __construct(
        private string $toWrite,
    ) {
    }

    public function process(CliInput $input, CliOutput $output, MiddlewareHandler $next): void
    {
        $output->write($this->toWrite);
        $next->process($input, $output);
    }
}
