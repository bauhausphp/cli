<?php

namespace Bauhaus\Cli;

use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;
use Psr\Container\ContainerInterface as PsrContainer;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;
use Throwable;

/**
 * @internal
 */
final class LazyEntrypoint implements CliEntrypoint
{
    public function __construct(
        private PsrContainer $container,
        private string $entrypointClass,
    ) {
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->load()->execute($input, $output);
    }

    private function load(): CliEntrypoint
    {
        try {
            return $this->container->get($this->entrypointClass);
        } catch (PsrNotFoundException $ex) {
            throw EntrypointCouldNotBeLoaded::notFound($this->entrypointClass, $ex);
        } catch (Throwable $ex) {
            throw EntrypointCouldNotBeLoaded::error($this->entrypointClass, $ex);
        }
    }
}
