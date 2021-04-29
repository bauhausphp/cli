<?php

namespace Bauhaus;

use Bauhaus\Cli\Processor\Handler;

trait DoublesTrait
{
    protected function dummyInput(): CliInput
    {
        return CliInput::fromString('does not matter');
    }

    protected function dummyOutput(): CliOutput
    {
        return CliOutput::to('php://memory');
    }

    protected function dummyHandler(): Handler
    {
        return new class implements Handler {
            public function execute(CliInput $input, CliOutput $output): void
            {
            }
        };
    }
}
