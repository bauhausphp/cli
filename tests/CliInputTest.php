<?php

namespace Bauhaus;

use Bauhaus\Cli\CommandId;
use PHPUnit\Framework\TestCase;

class CliInputTest extends TestCase
{
    /**
     * @test
     */
    public function determineCommandIdFromArgv(): void
    {
        $expected = new CommandId('command-id');

        $input = CliInput::fromArgv('./bin/console', 'command-id');
        $commandId = $input->commandId();

        $this->assertEquals($expected, $commandId);
    }
}
