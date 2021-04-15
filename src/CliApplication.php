<?php

namespace Bauhaus;

use Bauhaus\CliApplication\Processor;

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
            Processor::build($settings),
        );
    }

    public function run(string ...$argv): void
    {
        $input = CliInput::fromArgv(...$argv);

        $this->processor->execute($input, $this->output);
    }
}
