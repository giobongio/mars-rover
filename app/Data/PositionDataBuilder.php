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

    public function setX(int $x): PositionDataBuilder
    {
        $this->x = $x;
        return $this;
    }

    public function setY(int $y): PositionDataBuilder
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
        if ($this->x < 0 || $this->x >= config('app.planisphere.total_meridians')) {
            throw new InvalidArgumentException('Position X is invalid');
        }

        if ($this->y < 0 || $this->y >= config('app.planisphere.total_parallels')) {
            throw new InvalidArgumentException('Position Y is invalid');
        }

        if (empty($this->direction)) {
            throw new InvalidArgumentException('Direction is invalid');
        }

        return new PositionData(
            $this->x,
            $this->y,
            $this->direction,
        );
    }
}
