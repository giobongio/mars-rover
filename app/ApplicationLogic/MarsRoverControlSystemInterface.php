<?php

namespace App\ApplicationLogic;

use App\Data\Position;

interface MarsRoverControlSystemInterface
{
    public function sendCommands(array $commands): array;
    public function setPosition(Position $position): bool;
    public function getPosition(): Position;
}
