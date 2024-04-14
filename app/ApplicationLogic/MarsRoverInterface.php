<?php

namespace App\ApplicationLogic;

use App\Data\PositionResult;
use App\Data\Position;

interface MarsRoverInterface
{
    public function moveForward(): PositionResult;
    public function moveBackward(): PositionResult;
    public function rotateLeft(): PositionResult;
    public function rotateRight(): PositionResult;
    public function setPosition(Position $position): void;
    public function getPosition(): ?Position;
}
