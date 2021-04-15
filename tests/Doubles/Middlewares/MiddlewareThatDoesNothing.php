<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\CliInput;
use Bauhaus\CliApplication\Middleware\Middleware;
use Bauhaus\CliApplication\Middleware\MiddlewareHandler;
use Bauhaus\CliOutput;

class MiddlewareThatDoesNothing implements Middleware
{
    public function process(CliInput $input, CliOutput $output, MiddlewareHandler $next): void
    {
    }
}
