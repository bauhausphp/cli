<?php

namespace Bauhaus\Doubles\Middlewares;

use Bauhaus\Cli\Processor;
use Bauhaus\CliMiddleware;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

class CliMiddlewareThatWritesInOutput implements CliMiddleware
{
    public function __construct(
        private string $toWrite,
    ) {
    }

    public function execute(CliInput $input, CliOutput $output, Processor $next): void
    {
        $output->write($this->toWrite);
        $next->execute($input, $output);
    }
}
