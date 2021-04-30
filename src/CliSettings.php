<?php

namespace Bauhaus;

use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\PsrContainer\LazyEntrypoint;
use Bauhaus\Cli\PsrContainer\LazyMiddleware;
use Bauhaus\Cli\Processor\Middleware;
use Psr\Container\ContainerInterface as PsrContainer;

final class CliSettings
{
    private const DEFAULT_OUTPUT = 'php://stdout';

    private ?PsrContainer $container = null;
    private array $entrypoints = [];
    private array $middlewares = [];

    private function __construct(
        private string $output,
    ) {
    }

    public static function default(): self
    {
        return new self(
            self::DEFAULT_OUTPUT,
        );
    }

    public function output(): string
    {
        return $this->output;
    }

    /**
     * @return Entrypoint[]
     */
    public function entrypoints(): array
    {
        return $this->entrypoints;
    }

    /**
     * @return Middleware[]
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }

    public function withOutput(string $output): self
    {
        $new = $this->clone();
        $new->output = $output;

        return $new;
    }

    public function withPsrContainer(PsrContainer $container): self
    {
        $new = $this->clone();
        $new->container = $container;

        return $new;
    }

    public function withEntrypoints(Entrypoint|string ...$entrypoints): self
    {
        $entrypoints = array_map(
            fn ($e): Entrypoint => is_string($e) ? new LazyEntrypoint($this->container, $e) : $e,
            $entrypoints
        );

        $new = $this->clone();
        $new->entrypoints = $entrypoints;

        return $new;
    }

    public function withMiddlewares(Middleware|string ...$middlewares): self
    {
        $middlewares = array_map(
            fn ($m): Middleware => is_string($m) ? new LazyMiddleware($this->container, $m) : $m,
            $middlewares
        );

        $new = $this->clone();
        $new->middlewares = $middlewares;

        return $new;
    }

    private function clone(): self
    {
        return clone $this;
    }
}
