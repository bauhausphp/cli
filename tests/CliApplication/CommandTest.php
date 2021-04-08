<?php

namespace Bauhaus\CliApplication;

use Bauhaus\Doubles\AnotherSampleCommand;
use Bauhaus\Doubles\SampleCommand;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function entrypointClassesWithExpectedCommandId(): array
    {
        return [
            [SampleCommand::class, new CommandId('sample-id')],
            [AnotherSampleCommand::class, new CommandId('another-sample-id')],
        ];
    }

    /**
     * @test
     * @dataProvider entrypointClassesWithExpectedCommandId
     */
    public function defineIdFromEntrypointAttribute(string $entrypoint, CommandId $expected): void
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
        $input = Input::fromString('./bin sample-id');
        $command = Command::fromEntrypoint(SampleCommand::class);

        $result = $command->match($input);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function doNotMatchIfInputCommandIdIsNotEqual(): void
    {
        $input = Input::fromString('./bin another-sample-id');
        $command = Command::fromEntrypoint(SampleCommand::class);

        $result = $command->match($input);

        $this->assertfalse($result);
    }
}
