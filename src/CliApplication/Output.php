<?php

namespace Bauhaus\CliApplication;

use Bauhaus\CliApplication\Output\CannotWrite;

final class Output
{
    /** @var resource */
    private $resource;

    private function __construct(
        private string $output,
    ) {
        $this->assertCanWrite();
        $this->open();
    }

    public function __destruct()
    {
        $this->close();
    }

    public static function to(string $output): self
    {
        return new self($output);
    }

    public function write(string $toWrite): void
    {
        fwrite($this->resource, $toWrite);
    }

    private function assertCanWrite(): void
    {
        if (is_dir($this->output)) {
            throw CannotWrite::toDirectory($this->output);
        }
    }

    private function open(): void
    {
        $this->resource = fopen($this->output, 'a');
    }

    private function close(): void
    {
        fclose($this->resource);
    }
}
