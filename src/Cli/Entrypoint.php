<?php

namespace Bauhaus\Cli;

interface Entrypoint
{
    public function execute(Input $input, Output $output): void;
}
