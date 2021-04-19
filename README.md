# Cli

```php
<?php

use Bauhaus\CliApplication;
use Bauhaus\CliApplicationSettings;
use Bauhaus\CliEntrypoint;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;
use Bauhaus\CliMiddleware;
use Bauhaus\Cli\CommandId;
use Bauhaus\Cli\Processor\Handler;

#[CommandId('command-id')]
class MyCliEntrypoint implements CliEntrypoint
{
    public function execute(CliInput $input, CliOutput $output): void
    {
        $output->write("my entrypoing\n");
    }
}

class MyCliMiddleware implements CliMiddleware
{
    public function execute(CliInput $input,CliOutput $output, Handler $next): void
    {
        $output->write("my middleware\n");
        $next->execute($input, $output);
    }
}

$settings = CliApplicationSettings::default()
    ->withOutput('/var/tmp/file') // default is php://stdout
    ->withEntrypoints(
        new MyCliEntrypoint(),
    )
    ->withMiddlewares(
        new MyCliMiddleware(),
    );

$cliApplication = CliApplication::bootstrap($settings);

$cliApplication->run('./bin', 'command-id'); // it could be $cliApplication->run($_SERVER['argv']);
```