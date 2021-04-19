<?php

namespace Bauhaus;

use Bauhaus\Cli\Processor;

interface CliMiddleware
{
    public function execute(CliInput $input, CliOutput $output, Processor $next): void;
}
