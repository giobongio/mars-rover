<?php

namespace App\Data;

class PositionResult
{
    public function __construct(
        public readonly Position $position,
        public readonly bool $success
    ) {
    }
}
