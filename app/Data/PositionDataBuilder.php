<?php

namespace App\Data;

use App\Enums\RoverDirection;
use App\Data\PositionData;
use InvalidArgumentException;

class PositionDataBuilder
{
    private int $pointX = 0;
    private int $pointY = 0;
    private string $roverDirection = "";

    public function setPointX(int $pointX): PositionDataBuilder
    {
        $this->pointX = $pointX;
        return $this;
    }

    public function setPointY(int $pointY): PositionDataBuilder
    {
        $this->pointY = $pointY;
        return $this;
    }

    public function setRoverDirection(int $roverDirection): PositionDataBuilder
    {
        $this->roverDirection = $roverDirection;
        return $this;
    }

    public function build(): PositionData
    {
        if ($this->pointX <= 0) {
            throw new InvalidArgumentException('Point X is invalid');
        }

        if ($this->pointY <= 0) {
            throw new InvalidArgumentException('Point Y is invalid');
        }

        $roverDirectionValue = RoverDirection::getValueFromName($this->roverDirection);
        if (!RoverDirection::isValid($roverDirectionValue)) {
            throw new InvalidArgumentException('Rover direction is invalid');
        }

        return new PositionData(
            $this->pointX,
            $this->pointY,
            $this->roverDirection,
        );
    }
}
