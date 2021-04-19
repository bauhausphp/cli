<?php

namespace Bauhaus\Cli;

use Bauhaus\Doubles\Entrypoints\SampleCliEntrypoint;
use Bauhaus\InputStubberTrait;
use Bauhaus\OutputStubberTrait;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;

class LazyEntrypointTest extends TestCase
{
    use InputStubberTrait, OutputStubberTrait;

    private PsrContainer|MockObject $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(PsrContainer::class);
    }

    /**
     * @test
     */
    public function doNotLoadEntrypointIfExecuteIsNotCalled(): void
    {
        $this->container
            ->expects($this->never())
            ->method('get');

        new LazyEntrypoint($this->container, SampleCliEntrypoint::class);
    }

    /**
     * @test
     */
    public function loadEntrypointFromContainerBeforeItsExecution(): void
    {
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with(SampleCliEntrypoint::class)
            ->willReturn(new SampleCliEntrypoint());

        $entrypoint = new LazyEntrypoint($this->container, SampleCliEntrypoint::class);
        $entrypoint->execute($this->stubbedInput(), $this->stubbedOutput());
    }

    /**
     * @test
     */
    public function throwExceptionIfEntrypointIsNotFound(): void
    {
        $this->container
            ->method('get')
            ->willThrowException(new class extends Exception implements PsrNotFoundException {});

        $this->expectException(EntrypointCouldNotBeLoaded::class);
        $this->expectExceptionMessage(
            'Could not load entrypoint (not found) - ' . SampleCliEntrypoint::class
        );

        $entrypoint = new LazyEntrypoint($this->container, SampleCliEntrypoint::class);
        $entrypoint->execute($this->stubbedInput(), $this->stubbedOutput());
    }

    /**
     * @test
     */
    public function throwExceptionIf(): void
    {
        $this->container
            ->method('get')
            ->willThrowException(new Exception());

        $this->expectException(EntrypointCouldNotBeLoaded::class);
        $this->expectExceptionMessage(
            'Could not load entrypoint (generic error) - ' . SampleCliEntrypoint::class
        );

        $entrypoint = new LazyEntrypoint($this->container, SampleCliEntrypoint::class);
        $entrypoint->execute($this->stubbedInput(), $this->stubbedOutput());
    }
}
