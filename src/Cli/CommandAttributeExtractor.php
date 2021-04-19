<?php

namespace Bauhaus\Cli;

use Bauhaus\CliEntrypoint;
use ReflectionClass;

/**
 * @internal
 */
final class CommandAttributeExtractor
{
    private ReflectionClass $reflection;

    public function __construct(CliEntrypoint $entrypoint)
    {
        $this->reflection = new ReflectionClass($entrypoint);
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
