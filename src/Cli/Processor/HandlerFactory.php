<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\CliApplicationSettings;

/**
 * @internal
 */
class HandlerFactory
{
    private function __construct(
        private CliApplicationSettings $settings,
    ) {
    }

    public static function build(CliApplicationSettings $settings): Handler
    {
        $factory = new self($settings);
        $entrypointExecutor = $factory->buildEntrypointExecutor();

        return $factory->buildMiddlewareChain($entrypointExecutor);
    }

    private function buildEntrypointExecutor(): EntrypointExecutor
    {
        return new EntrypointExecutor(...$this->settings->entrypoints());
    }

    private function buildMiddlewareChain(Handler $next): Handler
    {
        $middlewares = array_reverse($this->settings->middlewares());

        foreach ($middlewares as $middleware) {
            $next = new MiddlewareDelegator($middleware, $next);
        }

        return $next;
    }
}
