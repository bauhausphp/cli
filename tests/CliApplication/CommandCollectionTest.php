<?php

namespace Bauhaus\CliApplication;

use ArrayIterator;
use Bauhaus\Doubles\AnotherSampleCommand;
use Bauhaus\Doubles\SampleCommand;
use PHPUnit\Framework\TestCase;

class CommandCollectionTest extends TestCase
{
    private CommandCollection $collection;

    protected function setUp(): void
    {
        $this->collection = CommandCollection::fromEntrypoints(
            SampleCommand::class,
            AnotherSampleCommand::class,
        );
    }

    /**
     * @test
     */
    public function returnNullIfNoCommandMatchesInput(): void
    {
        $input = Input::fromString('./bin not-matching');

        $null = $this->collection->findMatchingCommand($input);

        $this->assertNull($null);
    }

    public function inputsWithExpectedMatchingCommand(): array
    {
        return [
            ['./bin sample-id', Command::fromEntrypoint(SampleCommand::class)],
            ['./bin another-sample-id', Command::fromEntrypoint(AnotherSampleCommand::class)],
        ];
    }

    /**
     * @test
     * @dataProvider inputsWithExpectedMatchingCommand
     */
    public function returnCommandMatchingInput(string $rawInput, Command $expected): void
    {
        $input = Input::fromString($rawInput);

        $command = $this->collection->findMatchingCommand($input);

        $this->assertEquals($expected, $command);
    }

    /**
     * @test
     */
    public function isIterableHavingCommandsOrderedByTheirId(): void
    {
        $expected = new ArrayIterator([
            Command::fromEntrypoint(AnotherSampleCommand::class),
            Command::fromEntrypoint(SampleCommand::class),
        ]);

        $iterator = $this->collection->getIterator();

        $this->assertEquals($expected, $iterator);
    }
}
