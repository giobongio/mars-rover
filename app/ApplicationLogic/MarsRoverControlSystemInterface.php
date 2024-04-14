<?php

namespace App\ApplicationLogic;

use App\Data\Position;

interface MarsRoverControlSystemInterface
{
    public function sendCommands(array $commands): array;
    public function setPosition(Position $position): void;
    public function getPosition(): Position;
}
