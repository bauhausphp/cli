<?php

namespace Bauhaus\Cli\Processor;

use ArrayIterator;
use Bauhaus\Cli\Command;
use Bauhaus\Cli\Input;
use Bauhaus\Doubles\Entrypoints\AnotherSampleEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleEntrypoint;
use PHPUnit\Framework\TestCase;

class CommandCollectionTest extends TestCase
{
    private CommandCollection $collection;

    protected function setUp(): void
    {
        $this->collection = CommandCollection::fromEntrypoints(
            new SampleEntrypoint(),
            new AnotherSampleEntrypoint(),
        );
    }

    /**
     * @test
     */
    public function returnNullIfNoCommandMatchesInput(): void
    {
        $input = Input::fromString('./bin not-matching');

        $null = $this->collection->findMatch($input);

        $this->assertNull($null);
    }

    public function inputsWithExpectedMatchingCommand(): array
    {
        return [
            ['./bin sample-id', Command::fromEntrypoint(new SampleEntrypoint())],
            ['./bin another-sample-id', Command::fromEntrypoint(new AnotherSampleEntrypoint())],
        ];
    }

    /**
     * @test
     * @dataProvider inputsWithExpectedMatchingCommand
     */
    public function returnCommandMatchingInput(string $rawInput, Command $expected): void
    {
        $input = Input::fromString($rawInput);

        $command = $this->collection->findMatch($input);

        $this->assertEquals($expected, $command);
    }

    /**
     * @test
     */
    public function isIterableHavingCommandsOrderedByTheirId(): void
    {
        $expected = new ArrayIterator([
            Command::fromEntrypoint(new AnotherSampleEntrypoint()),
            Command::fromEntrypoint(new SampleEntrypoint()),
        ]);

        $iterator = $this->collection->getIterator();

        $this->assertEquals($expected, $iterator);
    }
}
