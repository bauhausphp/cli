<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\Cli\Processor;
use Bauhaus\CliApplicationSettings;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class ActualProcessor implements Processor
{
    private function __construct(
        private Processor $processorChain,
    ) {
    }

    public static function build(CliApplicationSettings $settings): ActualProcessor
    {
        return new self(Factory::build($settings));
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->processorChain->execute($input, $output);
    }
}
