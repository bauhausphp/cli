<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliMiddleware;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

class CliMiddlewareThatWritesInOutput implements CliMiddleware
{
    public function __construct(
        private string $toWrite,
    ) {
    }

    public function execute(CliInput $input, CliOutput $output, Handler $next): void
    {
        $output->write($this->toWrite);
        $next->execute($input, $output);
    }
}
