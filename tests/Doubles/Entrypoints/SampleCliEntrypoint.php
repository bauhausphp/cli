<?php

namespace Bauhaus\Doubles\Entrypoints;

use Bauhaus\CliEntrypoint;
use Bauhaus\Cli\CommandId;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

#[CommandId('sample-id')]
class SampleCliEntrypoint implements CliEntrypoint
{
    public function execute(CliInput $input, CliOutput $output): void
    {
        $output->write('sample entrypoint');
    }
}
