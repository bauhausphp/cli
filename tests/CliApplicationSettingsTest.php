<?php

namespace Bauhaus;

use Bauhaus\Doubles\Entrypoints\SampleCliEntrypoint;
use Bauhaus\Doubles\Middlewares\CliMiddlewareThatWritesInOutput;
use PHPUnit\Framework\TestCase;

class CliApplicationSettingsTest extends TestCase
{
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
    public function setMiddlewaresByNewInstance(): void
    {
        $originalSettings = CliApplicationSettings::default();

        $newSettings = $originalSettings->withMiddlewares(new CliMiddlewareThatWritesInOutput('#'));

        $this->assertNotSame($originalSettings, $newSettings);
        $this->assertEquals([], $originalSettings->entrypoints());
        $this->assertEquals([new CliMiddlewareThatWritesInOutput('#')], $newSettings->middlewares());
    }
}
