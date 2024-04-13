<?php

namespace App\Data;

use App\Enums\Direction;
use JsonSerializable;

class PositionData implements JsonSerializable
{
    public function __construct(
        public int $x,
        public int $y,
        public Direction $direction,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
