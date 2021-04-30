<?php

namespace Bauhaus\Cli\Attribute;

use Bauhaus\Cli\PsrContainer\LazyEntrypoint;
use Bauhaus\Cli\Entrypoint;
use ReflectionClass;

/**
 * @internal
 */
final class Extractor
{
    private ReflectionClass $reflection;

    public function __construct(Entrypoint $entrypoint)
    {
        if ($entrypoint instanceof LazyEntrypoint) {
            $entrypoint = $entrypoint->className();
        }

        $this->reflection = new ReflectionClass($entrypoint);
    }

    public function id(): Name
    {
        return $this->attributeInstance(Name::class);
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T
     */
    private function attributeInstance(string $class): object
    {
        // TODO Check if there is only one attr
        return $this->reflection->getAttributes($class)[0]->newInstance();
    }
}
