<?php

namespace Bauhaus\Cli\Processor;

use Bauhaus\Cli\Processor\Handlers\CommandExecutor;
use Bauhaus\Cli\Processor\Handlers\MiddlewareDelegator;
use Bauhaus\CliSettings;

/**
 * @internal
 */
final class HandlerFactory
{
    private CommandCollection $commands;

    private function __construct(
        private CliSettings $settings,
    ) {
        $this->commands = CommandCollection::fromEntrypoints(...$settings->entrypoints());
    }

    public static function build(CliSettings $settings): Handler
    {
        $factory = new self($settings);

        $entrypointExecutor = $factory->buildEntrypointExecutor();

        return $factory->buildMiddlewareChain($entrypointExecutor);
    }

    private function buildEntrypointExecutor(): CommandExecutor
    {
        return new CommandExecutor($this->commands);
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
