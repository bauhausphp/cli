<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Attribute\Name;
use Bauhaus\Cli\PsrContainer\LazyEntrypoint;
use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\Input;
use Bauhaus\Doubles\Entrypoints\AnotherSampleEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleEntrypoint;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;

class CommandTest extends TestCase
{
    public function entrypointsWithExpectedCommandIds(): array
    {
        $container = $this->createMock(PsrContainer::class);

        return [
            [
                new SampleEntrypoint(),
                new Name('sample-name'),
            ],
            [
                new AnotherSampleEntrypoint(),
                new Name('another-sample-name'),
            ],
            [
                new LazyEntrypoint($container, AnotherSampleEntrypoint::class),
                new Name('another-sample-name'),
            ],
        ];
    }

    /**
     * @test
     * @dataProvider entrypointsWithExpectedCommandIds
     */
    public function extractIdFromEntrypoint(Entrypoint $entrypoint, Name $expected): void
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
        $input = Input::fromString('./bin sample-name');
        $command = Command::fromEntrypoint(new SampleEntrypoint());

        $result = $command->match($input);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function doNotMatchIfInputCommandIdIsNotEqual(): void
    {
        $input = Input::fromString('./bin another-sample-name');
        $command = Command::fromEntrypoint(new SampleEntrypoint());

        $result = $command->match($input);

        $this->assertfalse($result);
    }
}
