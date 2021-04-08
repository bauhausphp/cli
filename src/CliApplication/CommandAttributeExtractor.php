<?php

namespace Bauhaus\CliApplication;

use ReflectionClass;

/**
 * @internal
 */
final class CommandAttributeExtractor
{
    private ReflectionClass $reflection;

    public function __construct(string $entrypointClass)
    {
        $this->reflection = new ReflectionClass($entrypointClass);
    }

    public function id(): CommandId
    {
        return $this->attributeInstance(CommandId::class);
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
