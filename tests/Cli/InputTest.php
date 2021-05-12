<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Attribute\Name;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    /**
     * @test
     */
    public function determineCommandIdFromArgv(): void
    {
        $expected = new Name('command-id');

        $input = Input::fromArgv('./bin/console', 'command-id');
        $commandId = $input->commandName();

        $this->assertEquals($expected, $commandId);
    }
}
