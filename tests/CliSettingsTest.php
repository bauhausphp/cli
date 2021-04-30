<?php

namespace Bauhaus;

use Bauhaus\Cli\PsrContainer\LazyEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleEntrypoint;
use Bauhaus\Doubles\Middlewares\MiddlewareThatWritesInOutput;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;

class CliSettingsTest extends TestCase
{
    private PsrContainer $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(PsrContainer::class);
    }

    /**
     * @test
     */
    public function defaultOutputIsPhpStdout(): void
    {
        $settings = CliSettings::default();

        $output = $settings->output();

        $this->assertEquals('php://stdout', $output);
    }

    /**
     * @test
     */
    public function allowOutputCustomizationByCreatingNewInstance(): void
    {
        $originalSettings = CliSettings::default();

        $newSettings = $originalSettings->withOutput('/var/tmp/some_file.txt');

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals('php://stdout', $originalSettings->output());
        $this->assertEquals('/var/tmp/some_file.txt', $newSettings->output());
    }

    /**
     * @test
     */
    public function setEntrypointsByNewInstance(): void
    {
        $originalSettings = CliSettings::default();

        $newSettings = $originalSettings->withEntrypoints(new SampleEntrypoint());

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals([new SampleEntrypoint()], $newSettings->entrypoints());
    }

    /**
     * @test
     */
    public function createLazyEntrypointInCaseClassNameIsProvided(): void
    {
        $originalSettings = CliSettings::default()
            ->withPsrContainer($this->container);

        $newSettings = $originalSettings->withEntrypoints(SampleEntrypoint::class);

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals(
            [new LazyEntrypoint($this->container, SampleEntrypoint::class)],
            $newSettings->entrypoints(),
        );
    }

    /**
     * @test
     */
    public function setMiddlewaresByNewInstance(): void
    {
        $originalSettings = CliSettings::default();

        $newSettings = $originalSettings->withMiddlewares(new MiddlewareThatWritesInOutput('#'));

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals([new MiddlewareThatWritesInOutput('#')], $newSettings->middlewares());
    }
}
