<?php

namespace App\Data;

use App\Enums\Direction;
use App\Data\PositionData;
use InvalidArgumentException;

class PositionDataBuilder
{
    private int $x = 0;
    private int $y = 0;
    private Direction $direction;

    public function setPointX(int $x): PositionDataBuilder
    {
        $this->x = $x;
        return $this;
    }

    public function setPointY(int $y): PositionDataBuilder
    {
        $this->y = $y;
        return $this;
    }

    public function setDirection(Direction $direction): PositionDataBuilder
    {
        $this->direction = $direction;
        return $this;
    }

    public function build(): PositionData
    {
        if ($this->x <= 0) {
            throw new InvalidArgumentException('Point X is invalid');
        }

        if ($this->y <= 0) {
            throw new InvalidArgumentException('Point Y is invalid');
        }

        if (empty($this->direction)) {
            throw new InvalidArgumentException('Rover direction is invalid');
        }

        return new PositionData(
            $this->x,
            $this->y,
            $this->direction,
        );
    }
}
