<?php

namespace Bauhaus\CliApplication;

use ArrayIterator;
use Bauhaus\CliInput;
use Bauhaus\Doubles\Entrypoints\AnotherSampleCliEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleCliEntrypoint;
use PHPUnit\Framework\TestCase;

class CommandCollectionTest extends TestCase
{
    private CommandCollection $collection;

    protected function setUp(): void
    {
        $this->collection = CommandCollection::fromEntrypoints(
            new SampleCliEntrypoint(),
            new AnotherSampleCliEntrypoint(),
        );
    }

    /**
     * @test
     */
    public function returnNullIfNoCommandMatchesInput(): void
    {
        $input = CliInput::fromString('./bin not-matching');

        $null = $this->collection->findMatch($input);

        $this->assertNull($null);
    }

    public function inputsWithExpectedMatchingCommand(): array
    {
        return [
            ['./bin sample-id', Command::fromEntrypoint(new SampleCliEntrypoint())],
            ['./bin another-sample-id', Command::fromEntrypoint(new AnotherSampleCliEntrypoint())],
        ];
    }

    /**
     * @test
     * @dataProvider inputsWithExpectedMatchingCommand
     */
    public function returnCommandMatchingInput(string $rawInput, Command $expected): void
    {
        $input = CliInput::fromString($rawInput);

        $command = $this->collection->findMatch($input);

        $this->assertEquals($expected, $command);
    }

    /**
     * @test
     */
    public function isIterableHavingCommandsOrderedByTheirId(): void
    {
        $expected = new ArrayIterator([
            Command::fromEntrypoint(new AnotherSampleCliEntrypoint()),
            Command::fromEntrypoint(new SampleCliEntrypoint()),
        ]);

        $iterator = $this->collection->getIterator();

        $this->assertEquals($expected, $iterator);
    }
}
