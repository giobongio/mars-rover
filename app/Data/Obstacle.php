<?php

namespace App\Data;

use InvalidArgumentException;

class Obstacle
{
    public readonly int $x;
    public readonly int $y;

    public function __construct(
        int $x,
        int $y,
    ) {
        if ($x < 0 || $x >= config('app.planisphere.total_meridians')) {
            throw new InvalidArgumentException('Obstacle X is invalid');
        }

        if ($y < 0 || $y >= config('app.planisphere.total_parallels')) {
            throw new InvalidArgumentException('Obstacle Y is invalid');
        }

        $this->x = $x;
        $this->y = $y;
    }
}
