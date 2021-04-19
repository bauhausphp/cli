<?php

namespace Bauhaus;

trait OutputStubberTrait
{
    protected function stubbedOutput(): CliOutput
    {
        return CliOutput::to('php://memory');
    }
}
