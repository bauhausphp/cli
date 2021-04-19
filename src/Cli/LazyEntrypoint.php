<?php

namespace Bauhaus\Cli;

use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;
use Psr\Container\ContainerInterface as PsrContainer;
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

    /**
     * @throws CouldNotLoadFromPsrContainer
     */
    public function execute(CliInput $input, CliOutput $output): void
    {
        $this->load()->execute($input, $output);
    }

    private function load(): CliEntrypoint
    {
        try {
            return $this->container->get($this->entrypointClass);
        } catch (Throwable $ex) {
            throw new CouldNotLoadFromPsrContainer($this->entrypointClass, $ex);
        }
    }
}
