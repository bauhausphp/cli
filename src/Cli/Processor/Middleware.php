<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

interface Middleware
{
    public function execute(Input $input, Output $output, Handler $next): void;
}
