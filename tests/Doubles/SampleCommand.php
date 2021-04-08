<?php

namespace Bauhaus\Doubles;

use Bauhaus\CliApplication\CommandEntrypoint;
use Bauhaus\CliApplication\CommandId;

#[CommandId('sample-id')]
class SampleCommand implements CommandEntrypoint
{
}
