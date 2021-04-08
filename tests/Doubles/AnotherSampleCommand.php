<?php

namespace Bauhaus\Doubles;

use Bauhaus\CliApplication\CommandEntrypoint;
use Bauhaus\CliApplication\CommandId;

#[CommandId('another-sample-id')]
class AnotherSampleCommand implements CommandEntrypoint
{
}
