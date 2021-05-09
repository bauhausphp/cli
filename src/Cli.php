<?php

namespace Bauhaus;

use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;
use Bauhaus\Cli\Processor;

final class Cli
{
    private function __construct(
        private Output $output,
        private Processor $processor,
    ) {
    }

    public static function bootstrap(CliSettings $settings): self
    {
        return new self(
            Output::to($settings->output()),
            Processor::build($settings),
        );
    }

    public function run(string ...$argv): void
    {
        $input = Input::fromArgv(...$argv);

        $this->processor->execute($input, $this->output);
    }
}
