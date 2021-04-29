<?php

namespace Bauhaus;

use Bauhaus\Doubles\Entrypoints\AnotherSampleCliEntrypoint;
use Bauhaus\Doubles\Entrypoints\SampleCliEntrypoint;
use Bauhaus\Doubles\Middlewares\MiddlewareThatWritesInOutput;
use Bauhaus\Doubles\SimpleContainer;
use PHPUnit\Framework\TestCase;

class CliApplicationTest extends TestCase
{
    private const OUTPUT = '/var/tmp/cli_application_test.txt';

    private CliApplication $cliApplication;

    protected function setUp(): void
    {
        $container = new SimpleContainer([
            AnotherSampleCliEntrypoint::class => new AnotherSampleCliEntrypoint(),
            MiddlewareThatWritesInOutput::class => new MiddlewareThatWritesInOutput('# '),
        ]);

        $settings = CliApplicationSettings::default()
            ->withOutput(self::OUTPUT)
            ->withPsrContainer($container)
            ->withEntrypoints(
                new SampleCliEntrypoint(),
                AnotherSampleCliEntrypoint::class,
            )
            ->withMiddlewares(
                new MiddlewareThatWritesInOutput('! '),
                MiddlewareThatWritesInOutput::class,
            );

        $this->cliApplication = CliApplication::bootstrap($settings);
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
            ['sample-id', '! # sample entrypoint'],
            ['another-sample-id', '! # another sample entrypoint'],
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
