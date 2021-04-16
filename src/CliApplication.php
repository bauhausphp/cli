<?php

namespace Bauhaus;

use Bauhaus\CliApplication\Processor;
use Bauhaus\CliApplication\Processor\ActualProcessor;

final class CliApplication
{
    private function __construct(
        private CliOutput $output,
        private Processor $processor,
    ) {
    }

    public static function bootstrap(CliApplicationSettings $settings): self
    {
        return new self(
            CliOutput::to($settings->output()),
            ActualProcessor::build($settings),
        );
    }

    public function run(string ...$argv): void
    {
        $input = CliInput::fromArgv(...$argv);

        $this->processor->execute($input, $this->output);
    }
}
