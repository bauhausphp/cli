<?php

namespace Bauhaus;

use Bauhaus\CliApplication\Processor;

interface CliMiddleware
{
    public function execute(CliInput $input, CliOutput $output, Processor $next): void;
}
