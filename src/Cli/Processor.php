<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Processor\HandlerFactory;
use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliSettings;

/**
 * @internal
 */
class Processor
{
    private function __construct(
        private Handler $handler,
    ) {
    }

    public static function build(CliSettings $settings): self
    {
        return new self(HandlerFactory::build($settings));
    }

    public function execute(Input $input, Output $output): void
    {
        $this->handler->execute($input, $output);
    }
}
