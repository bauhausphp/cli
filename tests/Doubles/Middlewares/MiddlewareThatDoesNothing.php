<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\Cli\Processor\Middleware;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

class MiddlewareThatDoesNothing implements Middleware
{
    public function execute(Input $input, Output $output, Handler $next): void
    {
        $next->execute($input, $output);
    }
}
