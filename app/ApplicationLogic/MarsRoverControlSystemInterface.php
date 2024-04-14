<?php

namespace App\ApplicationLogic;

interface MarsRoverControlSystemInterface
{
    public function sendCommands(string $commands): array;
}
