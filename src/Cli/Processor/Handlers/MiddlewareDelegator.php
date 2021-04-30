<?php

namespace Bauhaus\Cli\Processor\Handlers;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Processor\Middleware;
use Bauhaus\Cli\Output;

/**
 * @internal
 */
class MiddlewareDelegator implements Handler
{
    public function __construct(
        private Middleware $middleware,
        private Handler $next,
    ) {
    }

    public function execute(Input $input, Output $output): void
    {
        $this->middleware->execute($input, $output, $this->next);
    }
}
