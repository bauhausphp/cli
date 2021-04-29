<?php

namespace Bauhaus\Doubles;

use Psr\Container\ContainerInterface as PsrContainer;

class SimpleContainer implements PsrContainer
{
    public function __construct(
        private array $services,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $id)
    {
        return $this->services[$id] ?? null;
    }
}
