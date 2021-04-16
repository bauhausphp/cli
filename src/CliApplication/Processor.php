<?php

namespace Bauhaus\CliApplication;

use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
interface Processor
{
    public function execute(CliInput $input, CliOutput $output): void;
}
