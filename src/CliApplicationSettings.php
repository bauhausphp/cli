<?php

namespace Bauhaus;

final class CliApplicationSettings
{
    private const DEFAULT_OUTPUT = 'php://stdout';

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
     * @return CliEntrypoint[]
     */
    public function entrypoints(): array
    {
        return $this->entrypoints;
    }

    /**
     * @return CliMiddleware[]
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

    public function withEntrypoints(CliEntrypoint ...$entrypoints): self
    {
        $new = $this->clone();
        $new->entrypoints = $entrypoints;

        return $new;
    }

    public function withMiddlewares(CliMiddleware ...$middlewares): self
    {
        $new = $this->clone();
        $new->middlewares = $middlewares;

        return $new;
    }

    private function clone(): self
    {
        return clone $this;
    }
}
