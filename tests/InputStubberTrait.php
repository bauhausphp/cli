<?php

namespace Bauhaus;

trait InputStubberTrait
{
    protected function stubbedInput(): CliInput
    {
        return CliInput::fromString('does not matter');
    }
}
