<?php

namespace App\Data;

use App\Enums\Direction;
use App\Data\ObstacleData;
use InvalidArgumentException;

class ObstacleDataBuilder
{
    private int $x = 0;
    private int $y = 0;

    public function setX(int $x): ObstacleDataBuilder
    {
        $this->x = $x;
        return $this;
    }

    public function setY(int $y): ObstacleDataBuilder
    {
        $this->y = $y;
        return $this;
    }

    public function build(): ObstacleData
    {
        if ($this->x < 0 || $this->x >= config('app.planisphere.total_meridians')) {
            throw new InvalidArgumentException('Obstacle X is invalid');
        }

        if ($this->y < 0 || $this->y >= config('app.planisphere.total_parallels')) {
            throw new InvalidArgumentException('Obstacle Y is invalid');
        }

        return new ObstacleData(
            $this->x,
            $this->y
        );
    }
}
