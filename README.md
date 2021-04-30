# Cli

```php
<?php

use Bauhaus\Cli;
use Bauhaus\CliSettings;
use Bauhaus\Cli\Entrypoint;
use Bauhaus\Cli\Input;
use Bauhaus\Cli\Output;
use Bauhaus\Cli\Processor\Middleware;
use Bauhaus\Cli\Attribute\Name;
use Bauhaus\Cli\Processor\Handler;

#[Name('command-id')]
class MyCliEntrypoint implements Entrypoint
{
    public function execute(Input $input, Output $output): void
    {
        $output->write("my entrypoing\n");
    }
}

class MyCliMiddleware implements Middleware
{
    public function execute(Input $input,Output $output, Handler $next): void
    {
        $output->write("my middleware\n");
        $next->execute($input, $output);
    }
}

$settings = CliSettings::default()
    ->withOutput('/var/tmp/file') // default is php://stdout
    ->withEntrypoints(
        new MyCliEntrypoint(),
    )
    ->withMiddlewares(
        new MyCliMiddleware(),
    );

$cliApplication = Cli::bootstrap($settings);

$cliApplication->run('./bin', 'command-id'); // it could be $cliApplication->run($_SERVER['argv']);
```