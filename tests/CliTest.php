<?php

namespace Bauhaus;

use Bauhaus\Doubles\Entrypoints\AnotherSampleEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleEntrypoint;
use Bauhaus\Doubles\Middlewares\MiddlewareThatWritesInOutput;
use Bauhaus\Doubles\SimpleContainer;
use PHPUnit\Framework\TestCase;

class CliTest extends TestCase
{
    private const OUTPUT = '/var/tmp/cli_application_test.txt';

    private Cli $cliApplication;

    protected function setUp(): void
    {
        $container = new SimpleContainer([
            AnotherSampleEntrypoint::class => new AnotherSampleEntrypoint(),
            MiddlewareThatWritesInOutput::class => new MiddlewareThatWritesInOutput('# '),
        ]);

        $settings = CliSettings::default()
            ->withOutput(self::OUTPUT)
            ->withPsrContainer($container)
            ->withEntrypoints(
                new SampleEntrypoint(),
                AnotherSampleEntrypoint::class,
            )
            ->withMiddlewares(
                new MiddlewareThatWritesInOutput('! '),
                MiddlewareThatWritesInOutput::class,
            );

        $this->cliApplication = Cli::bootstrap($settings);
    }

    protected function tearDown(): void
    {
        if (file_exists(self::OUTPUT)) {
            unlink(self::OUTPUT);
        }
    }

    public function commandIdWithExpectedOutput(): array
    {
        return [
            ['sample-name', '! # sample entrypoint'],
            ['another-sample-name', '! # another sample entrypoint'],
        ];
    }

    /**
     * @test
     * @dataProvider commandIdWithExpectedOutput
     */
    public function executeEntrypointPassingThroughMiddlewares(string $id, string $expected): void
    {
        $this->cliApplication->run('./console', $id);

        // TODO update after https://github.com/sebastianbergmann/phpunit/pull/4649
        $this->assertStringEqualsFile(self::OUTPUT, $expected);
    }
}
