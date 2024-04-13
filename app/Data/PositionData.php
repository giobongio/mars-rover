<?php

namespace App\Data;

use App\Enums\Direction;
use JsonSerializable;

class PositionData implements JsonSerializable
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly Direction $direction,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
