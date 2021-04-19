<?php

namespace Bauhaus;

interface CliEntrypoint
{
    public function execute(CliInput $input, CliOutput $output): void;
}
