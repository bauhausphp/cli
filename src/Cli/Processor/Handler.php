<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

interface Handler
{
    public function execute(Input $input, Output $output): void;
}
