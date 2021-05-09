<?php

namespace Bauhaus\Cli\PsrContainer;

use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;
use Psr\Container\ContainerInterface as PsrContainer;
use Throwable;

/**
 * @internal
 */
final class LazyEntrypoint implements Entrypoint
{
    public function __construct(
        private PsrContainer $container,
        private string $entrypointClass,
    ) {
        // TODO check if $entrypointClass is CliEntrypoint
    }

    public function className(): string
    {
        return $this->entrypointClass;
    }

    /**
     * @throws CouldNotLoadFromPsrContainer
     */
    public function execute(Input $input, Output $output): void
    {
        $this->load()->execute($input, $output);
    }

    private function load(): Entrypoint
    {
        try {
            return $this->container->get($this->entrypointClass);
        } catch (Throwable $ex) {
            throw new CouldNotLoadFromPsrContainer($this->entrypointClass, $ex);
        }
    }
}
