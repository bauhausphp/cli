<?php

namespace Bauhaus\Cli;

use Bauhaus\Cli\Processor\Handler;
use Bauhaus\CliInput;
use Bauhaus\CliMiddleware;
use Bauhaus\CliOutput;
use Psr\Container\ContainerInterface as PsrContainer;
use Throwable;

/**
 * @internal
 */
final class LazyMiddleware implements CliMiddleware
{
    public function __construct(
        private PsrContainer $container,
        private string $middlewareClass,
    ) {
    }

    /**
     * @throws CouldNotLoadFromPsrContainer
     */
    public function execute(CliInput $input, CliOutput $output, Handler $next): void
    {
        $this->load()->execute($input, $output, $next);
    }

    private function load(): CliMiddleware
    {
        try {
            return $this->container->get($this->middlewareClass);
        } catch (Throwable $ex) {
            throw new CouldNotLoadFromPsrContainer($this->middlewareClass, $ex);
        }
    }
}
