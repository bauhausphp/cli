<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Output\Stream;

final class Output
{
    private Stream $stream;

    private function __construct(string $output)
    {
        $this->stream = new Stream($output);
        $this->stream->open();
    }

    public function __destruct()
    {
        $this->stream->close();
    }

    public static function to(string $output): self
    {
        return new self($output);
    }

    public function write(string $toWrite): void
    {
        $this->stream->write($toWrite);
    }
}
