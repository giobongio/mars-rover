<?php

namespace App\Data;

use App\Data\Position;

class CommandResult
{
    public function __construct(
        public readonly string $command,
        public readonly ?Position $position = null,
        public readonly bool $success
    ) {
    }
}