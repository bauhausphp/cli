<?php

namespace Bauhaus\CliApplication;

use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    /**
     * @test
     */
    public function extractCommandIdFromGlobalArgv(): void
    {
        $_SERVER['argv'] = [
            './bin/console',
            'command-id',
        ];

        $input = Input::fromGlobal();
        $commandId = $input->commandId();

        $expected = new CommandId('command-id');
        $this->assertEquals($expected, $commandId);
    }
}