<?php

namespace Bauhaus\CliApplication\Processor;

use Bauhaus\CliApplication\Processor;
use Bauhaus\CliApplicationSettings;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class ProcessorChainFactory
{
    private function __construct(
        private CliApplicationSettings $settings,
    ) {
    }

    public static function build(CliApplicationSettings $settings): Processor
    {
        $factory = new self($settings);
        $entrypointExecutor = $factory->buildEntrypointExecutor();

        return $factory->buildMiddlewareChain($entrypointExecutor);
    }

    private function buildEntrypointExecutor(): EntrypointExecutor
    {
        return new EntrypointExecutor(...$this->settings->entrypoints());
    }

    private function buildMiddlewareChain(Processor $next): Processor
    {
        $middlewares = array_reverse($this->settings->middlewares());

        foreach ($middlewares as $middleware) {
            $next = new MiddlewareDelegator($middleware, $next);
        }

        return $next;
    }
}
