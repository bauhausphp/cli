<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliMiddleware;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

class CliMiddlewareThatDoesNothing implements CliMiddleware
{
    public function execute(CliInput $input, CliOutput $output, Handler $next): void
    {
        $next->execute($input, $output);
    }
}
