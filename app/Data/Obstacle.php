<?php

namespace App\Data;

use JsonSerializable;
use InvalidArgumentException;

class Obstacle implements JsonSerializable
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

    public function clone(): Obstacle
    {
        return new Obstacle(
            $this->x, 
            $this->y
        );
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
