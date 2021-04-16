<?php

namespace Bauhaus\CliApplication\Processor;

use Bauhaus\CliApplication\Processor;
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
        return new self(ProcessorChainFactory::build($settings));
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->processorChain->execute($input, $output);
    }
}
