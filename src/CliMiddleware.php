<?php

namespace Bauhaus;

use Bauhaus\Cli\Processor\Handler;

interface CliMiddleware
{
    public function execute(CliInput $input, CliOutput $output, Handler $next): void;
}
