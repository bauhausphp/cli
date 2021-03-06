<?php

namespace Bauhaus\Cli\PsrContainer;

use Bauhaus\Doubles\Entrypoints\SampleEntrypoint;
use Bauhaus\DoublesTrait;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;

class LazyEntrypointTest extends TestCase
{
    use DoublesTrait;

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

        new LazyEntrypoint($this->container, SampleEntrypoint::class);
    }

    /**
     * @test
     */
    public function loadEntrypointFromContainerBeforeItsExecution(): void
    {
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with(SampleEntrypoint::class)
            ->willReturn(new SampleEntrypoint());

        $entrypoint = new LazyEntrypoint($this->container, SampleEntrypoint::class);
        $entrypoint->execute($this->dummyInput(), $this->dummyOutput());
    }

    /**
     * @test
     */
    public function throwExceptionIfEntrypointCanNotBeLoadedFromContainer(): void
    {
        $this->container
            ->method('get')
            ->willThrowException(new Exception('error msg'));
        $class = SampleEntrypoint::class;

        $this->expectException(CouldNotLoadFromPsrContainer::class);
        $this->expectExceptionMessage(<<<MSG
            Could not load service from PSR container
                id: $class
                reason: error msg
            MSG);

        $entrypoint = new LazyEntrypoint($this->container, $class);
        $entrypoint->execute($this->dummyInput(), $this->dummyOutput());
    }
}
