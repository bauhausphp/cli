<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Output\CannotWrite;
use Bauhaus\Cli\Output\Stream;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TypeError;

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

    /**
     * @test
     */
    public function cannotWriteInStreamAfterOutputIsDestructed(): void
    {
        $output = Output::to(self::OUTPUT);
        $stream = $this->extractStream($output);
        unset($output);

        $this->expectException(TypeError::class);

        $stream->write('foo');
    }

    private function extractStream(Output $output): Stream
    {
        $r = new ReflectionClass($output);
        $p = $r->getProperty('stream');
        $p->setAccessible(true);

        return $p->getValue($output);
    }
}
