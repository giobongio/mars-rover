<?php

namespace App\Data;

use JsonSerializable;

class PositionResult implements JsonSerializable
{
    public function __construct(
        public readonly Position $position,
        public readonly bool $success
    ) {
    }

    public function clone(): PositionResult
    {
        return new PositionResult(
            $this->position, 
            $this->success
        );
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
