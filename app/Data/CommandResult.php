<?php

namespace App\Data;

use App\Data\Position;
use JsonSerializable;

class CommandResult implements JsonSerializable
{
    public function __construct(
        public readonly string $command,
        public readonly ?Position $position = null,
        public readonly bool $success
    ) {
    }

    public function clone(): CommandResult
    {
        return new CommandResult(
            $this->command, 
            $this->position->clone(),
            $this->success
        );
    }

    public function jsonSerialize(): mixed
    {
        return json_encode((object) get_object_vars($this));
    }
}
