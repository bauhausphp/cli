<?php

namespace Bauhaus\CliApplication;

use Bauhaus\CliApplication\Output\CannotWrite;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
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

        Output::to($dir);
    }

    /**
     * @test
     */
    public function writeByAppendingStringToOutput(): void
    {
        $output = Output::to(self::OUTPUT);

        $output->write('foo');
        $output->write('bar');

        $this->assertStringEqualsFile(self::OUTPUT, 'foobar');
    }
}
