<?php

namespace App\ApplicationLogic;

use App\Data\CommandResult;
use App\Enums\Command;

class MarsRoverControlSystem implements MarsRoverControlSystemInterface
{
    public function __construct(private readonly MarsRoverInterface $marsRover) 
    {
    }

    public function sendCommands(string $commands): array
    {
        $commandResults = [];

        foreach(mb_str_split($commands) as $command) 
        {
            if(!Command::isValid($command)) {
                $commandResults[] = new CommandResult($command, $this->marsRover->getPosition(), false);
                continue;
            }

            switch($command) 
            {
                case Command::MOVE_FORWARD->value:
                    $positionResult = $this->marsRover->moveForward();
                    break;
    
                case Command::MOVE_BACKWARD->value:
                    $positionResult = $this->marsRover->moveBackward();
                    break;
    
                case Command::ROTATE_LEFT->value:
                    $positionResult = $this->marsRover->rotateLeft();
                    break;
    
                case Command::ROTATE_RIGHT->value:
                    $positionResult = $this->marsRover->rotateRight();
                    break;
            }

            $commandResults[] = new CommandResult($command, $positionResult->position, $positionResult->success);
        }

        return $commandResults;
    }
}
