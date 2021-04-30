<?php

namespace Bauhaus\Cli\PsrContainer;

use Bauhaus\Doubles\Middlewares\MiddlewareThatDoesNothing;
use Bauhaus\DoublesTrait;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;

class LazyMiddlewareTest extends TestCase
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

        new LazyMiddleware($this->container, MiddlewareThatDoesNothing::class);
    }

    /**
     * @test
     */
    public function loadEntrypointFromContainerBeforeItsExecution(): void
    {
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with(MiddlewareThatDoesNothing::class)
            ->willReturn(new MiddlewareThatDoesNothing());

        $middleware = new LazyMiddleware($this->container, MiddlewareThatDoesNothing::class);
        $middleware->execute($this->dummyInput(), $this->dummyOutput(), $this->dummyHandler());
    }

    /**
     * @test
     */
    public function throwExceptionIfEntrypointIsNotFound(): void
    {
        $this->container
            ->method('get')
            ->willThrowException(new Exception('error msg'));
        $class = MiddlewareThatDoesNothing::class;

        $this->expectException(CouldNotLoadFromPsrContainer::class);
        $this->expectExceptionMessage(<<<MSG
            Could not load service from PSR container
                id: $class
                reason: error msg
            MSG);

        $middleware = new LazyMiddleware($this->container, $class);
        $middleware->execute($this->dummyInput(), $this->dummyOutput(), $this->dummyHandler());
    }
}
