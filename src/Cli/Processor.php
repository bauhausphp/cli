<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Processor\HandlerFactory;
use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliApplicationSettings;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class Processor
{
    private function __construct(
        private Handler $handler,
    ) {
    }

    public static function build(CliApplicationSettings $settings): self
    {
        return new self(HandlerFactory::build($settings));
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->handler->execute($input, $output);
    }
}
