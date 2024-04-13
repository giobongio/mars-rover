<?php

namespace App\Data;

use JsonSerializable;

class ObstacleData implements JsonSerializable
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
