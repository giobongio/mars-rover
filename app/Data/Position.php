<?php

namespace App\Data;

use App\Enums\Direction;
use JsonSerializable;
use InvalidArgumentException;

class Position implements JsonSerializable
{
    public int $x;
    public int $y;
    public Direction $direction;

    public function __construct(
        int $x,
        int $y,
        Direction $direction,
    ) {
        if ($x < 0 || $x >= config('app.planisphere.total_meridians')) {
            throw new InvalidArgumentException('Position X is invalid');
        }

        if ($y < 0 || $y >= config('app.planisphere.total_parallels')) {
            throw new InvalidArgumentException('Position Y is invalid');
        }

        if (!Direction::isValid($direction->value)) {
            throw new InvalidArgumentException('Direction is invalid');
        }

        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
