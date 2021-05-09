<?php

namespace Bauhaus;

use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;
use Bauhaus\Cli\Processor\Handler;

trait DoublesTrait
{
    protected function dummyInput(): Input
    {
        return Input::fromString('does not matter');
    }

    protected function dummyOutput(): Output
    {
        return Output::to('php://memory');
    }

    protected function dummyHandler(): Handler
    {
        return new class implements Handler {
            public function execute(Input $input, Output $output): void
            {
            }
        };
    }
}
