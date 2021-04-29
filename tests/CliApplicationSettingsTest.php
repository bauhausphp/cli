<?php

namespace Bauhaus;

use Bauhaus\Cli\LazyEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleCliEntrypoint;
use Bauhaus\Doubles\Middlewares\MiddlewareThatWritesInOutput;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface as PsrContainer;

class CliApplicationSettingsTest extends TestCase
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
        $settings = CliApplicationSettings::default();

        $output = $settings->output();

        $this->assertEquals('php://stdout', $output);
    }

    /**
     * @test
     */
    public function allowOutputCustomizationByCreatingNewInstance(): void
    {
        $originalSettings = CliApplicationSettings::default();

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
        $originalSettings = CliApplicationSettings::default();

        $newSettings = $originalSettings->withEntrypoints(new SampleCliEntrypoint());

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals([new SampleCliEntrypoint()], $newSettings->entrypoints());
    }

    /**
     * @test
     */
    public function createLazyEntrypointInCaseClassNameIsProvided(): void
    {
        $originalSettings = CliApplicationSettings::default()
            ->withPsrContainer($this->container);

        $newSettings = $originalSettings->withEntrypoints(SampleCliEntrypoint::class);

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals(
            [new LazyEntrypoint($this->container, SampleCliEntrypoint::class)],
            $newSettings->entrypoints(),
        );
    }

    /**
     * @test
     */
    public function setMiddlewaresByNewInstance(): void
    {
        $originalSettings = CliApplicationSettings::default();

        $newSettings = $originalSettings->withMiddlewares(new MiddlewareThatWritesInOutput('#'));

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals([new MiddlewareThatWritesInOutput('#')], $newSettings->middlewares());
    }
}
