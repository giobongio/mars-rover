<?php

namespace App\Data;

use App\Data\Position;
use App\Enums\Command;

class CommandResult
{
    public function __construct(
        public readonly Command $command,
        public readonly ?Position $position = null,
        public readonly bool $success = true
    ) {
    }
}