<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\CliInput;
use Bauhaus\CliMiddleware;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class MiddlewareDelegator implements Handler
{
    public function __construct(
        private CliMiddleware $middleware,
        private Handler $next,
    ) {
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->middleware->execute($input, $output, $this->next);
    }
}
