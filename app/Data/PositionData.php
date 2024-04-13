<?php

namespace App\Data;

use JsonSerializable;

class PositionData implements JsonSerializable
{
    public function __construct(
        public readonly int $id = 0,
        public readonly int $pointX = 0,
        public readonly int $pointY = 0,
        public readonly string $roverDirection = "",
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
