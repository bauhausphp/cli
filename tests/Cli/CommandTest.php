<?php

namespace Bauhaus\Cli;

use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use Bauhaus\Doubles\Entrypoints\AnotherSampleCliEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleCliEntrypoint;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function entrypointWithExpectedCommandId(): array
    {
        return [
            [new SampleCliEntrypoint(), new CommandId('sample-id')],
            [new AnotherSampleCliEntrypoint(), new CommandId('another-sample-id')],
        ];
    }

    /**
     * @test
     * @dataProvider entrypointWithExpectedCommandId
     */
    public function extractIdFromEntrypoint(CliEntrypoint $entrypoint, CommandId $expected): void
    {
        $command = Command::fromEntrypoint($entrypoint);

        $id = $command->id();

        $this->assertEquals($expected, $id);
    }

    /**
     * @test
     */
    public function matchIfInputCommandIdIsEqual(): void
    {
        $input = CliInput::fromString('./bin sample-id');
        $command = Command::fromEntrypoint(new SampleCliEntrypoint());

        $result = $command->match($input);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function doNotMatchIfInputCommandIdIsNotEqual(): void
    {
        $input = CliInput::fromString('./bin another-sample-id');
        $command = Command::fromEntrypoint(new SampleCliEntrypoint());

        $result = $command->match($input);

        $this->assertfalse($result);
    }
}
