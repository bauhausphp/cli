<?php

namespace Bauhaus;

use Bauhaus\Cli\Output\CannotWrite;
use PHPUnit\Framework\TestCase;

class CliOutputTest extends TestCase
{
    private const OUTPUT = '/var/tmp/output_test.txt';

    protected function tearDown(): void
    {
        if (file_exists(self::OUTPUT)) {
            unlink(self::OUTPUT);
        }
    }

    /**
     * @test
     */
    public function throwExceptionIfOutputIsADirectory(): void
    {
        $dir = '/var/tmp';

        $this->expectException(CannotWrite::class);
        $this->expectExceptionMessage("Provided output is a directory: $dir");

        CliOutput::to($dir);
    }

    /**
     * @test
     */
    public function writeByAppendingStringToOutput(): void
    {
        $output = CliOutput::to(self::OUTPUT);

        $output->write('foo');
        $output->write('bar');

        $this->assertStringEqualsFile(self::OUTPUT, 'foobar');
    }
}
