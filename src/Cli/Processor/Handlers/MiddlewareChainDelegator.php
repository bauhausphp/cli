<?php

namespace Bauhaus\Cli\Processor\Handlers;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliInput;
use Bauhaus\CliMiddleware;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class MiddlewareChainDelegator implements Handler
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
