<?php

namespace Bauhaus\Cli\Output;

final class Stream
{
    /** @var resource */
    private $resource;

    public function __construct(
        private string $filename,
    ) {
        $this->assertCanWrite();
    }

    public function open(): void
    {
        $this->resource = fopen($this->filename, 'a');
    }

    public function write(string $toWrite): void
    {
        fwrite($this->resource, $toWrite);
    }

    public function close(): void
    {
        fclose($this->resource);
    }

    private function assertCanWrite(): void
    {
        if (is_dir($this->filename)) {
            throw CannotWrite::toDirectory($this->filename);
        }
    }
}
