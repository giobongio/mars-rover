<?php

namespace App\Data;

use App\Enums\RoverDirection;
use JsonSerializable;

class PositionData implements JsonSerializable
{
    public function __construct(
        public readonly int $pointX,
        public readonly int $pointY,
        public readonly RoverDirection $roverDirection,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
