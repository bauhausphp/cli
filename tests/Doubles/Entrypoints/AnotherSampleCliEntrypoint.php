<?php

namespace Bauhaus\Doubles\Entrypoints;

use Bauhaus\CliEntrypoint;
use Bauhaus\Cli\CommandId;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

#[CommandId('another-sample-id')]
class AnotherSampleCliEntrypoint implements CliEntrypoint
{
    public function execute(CliInput $input, CliOutput $output): void
    {
        $output->write('another sample entrypoint');
    }
}
