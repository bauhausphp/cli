<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
interface Handler
{
    public function execute(CliInput $input, CliOutput $output): void;
}
