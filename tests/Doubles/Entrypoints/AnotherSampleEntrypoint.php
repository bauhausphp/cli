<?php

namespace Bauhaus\Doubles\Entrypoints;

use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\Attribute\Name;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;

#[Name('another-sample-id')]
class AnotherSampleEntrypoint implements Entrypoint
{
    public function execute(Input $input, Output $output): void
    {
        $output->write('another sample entrypoint');
    }
}
