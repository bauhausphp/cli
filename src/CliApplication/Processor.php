<?php

namespace Bauhaus\CliApplication;

use Bauhaus\CliApplicationSettings;
use Bauhaus\CliInput;
use Bauhaus\CliOutput;

/**
 * @internal
 */
class Processor
{
    private function __construct(
        private CommandCollection $commands,
    ) {
    }

    public static function build(CliApplicationSettings $settings): Processor
    {
        $commands = CommandCollection::fromEntrypoints(...$settings->entrypoints());

        return new self($commands);
    }

    public function execute(CliInput $input, CliOutput $output): void
    {
        $command = $this->commands->findMatch($input);

        $command->execute($input, $output);
    }
}
