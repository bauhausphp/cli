<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\Cli\CommandCollection;
use Bauhaus\Cli\Processor\Handlers\EntrypointExecutor;
use Bauhaus\Cli\Processor\Handlers\MiddlewareChainDelegator;
use Bauhaus\CliApplicationSettings;

/**
 * @internal
 */
class HandlerFactory
{
    private CommandCollection $commands;

    private function __construct(
        private CliApplicationSettings $settings,
    ) {
        $this->commands = CommandCollection::fromEntrypoints(...$settings->entrypoints());
    }

    public static function build(CliApplicationSettings $settings): Handler
    {
        $factory = new self($settings);

        $entrypointExecutor = $factory->buildEntrypointExecutor();

        return $factory->buildMiddlewareChain($entrypointExecutor);
    }

    private function buildEntrypointExecutor(): EntrypointExecutor
    {
        return new EntrypointExecutor($this->commands);
    }

    private function buildMiddlewareChain(Handler $next): Handler
    {
        $middlewares = array_reverse($this->settings->middlewares());

        foreach ($middlewares as $middleware) {
            $next = new MiddlewareChainDelegator($middleware, $next);
        }

        return $next;
    }
}
