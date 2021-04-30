<?php

namespace Bauhaus\Cli\PsrContainer;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Processor\Middleware;
use Bauhaus\Cli\Output;
use Psr\Container\ContainerInterface as PsrContainer;
use Throwable;

/**
 * @internal
 */
final class LazyMiddleware implements Middleware
{
    public function __construct(
        private PsrContainer $container,
        private string $middlewareClass,
    ) {
    }

    /**
     * @throws CouldNotLoadFromPsrContainer
     */
    public function execute(Input $input, Output $output, Handler $next): void
    {
        $this->load()->execute($input, $output, $next);
    }

    private function load(): Middleware
    {
        try {
            return $this->container->get($this->middlewareClass);
        } catch (Throwable $ex) {
            throw new CouldNotLoadFromPsrContainer($this->middlewareClass, $ex);
        }
    }
}
