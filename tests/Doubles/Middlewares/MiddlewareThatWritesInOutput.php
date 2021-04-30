<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\Cli\Processor\Middleware;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

class MiddlewareThatWritesInOutput implements Middleware
{
    public function __construct(
        private string $toWrite,
    ) {
    }

    public function execute(Input $input, Output $output, Handler $next): void
    {
        $output->write($this->toWrite);
        $next->execute($input, $output);
    }
}
