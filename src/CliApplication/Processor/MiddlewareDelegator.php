<?php

namespace Bauhaus\CliApplication\Processor;

use Bauhaus\CliApplication\Processor;
use Bauhaus\CliInput;
use Bauhaus\CliMiddleware;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class MiddlewareDelegator implements Processor
{
    public function __construct(
        private CliMiddleware $middleware,
        private Processor $next,
    ) {
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->middleware->execute($input, $output, $this->next);
    }
}
