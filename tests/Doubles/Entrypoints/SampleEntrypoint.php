<?php

namespace Bauhaus\Doubles\Entrypoints;

use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\Attribute\Name;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

#[Name('sample-name')]
class SampleEntrypoint implements Entrypoint
{
    public function execute(Input $input, Output $output): void
    {
        $output->write('sample entrypoint');
    }
}
