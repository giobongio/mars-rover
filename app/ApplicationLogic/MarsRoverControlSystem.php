<?php

namespace App\ApplicationLogic;

use App\Data\Position;
use App\Data\CommandResult;
use App\Enums\Command;
use App\Enums\Direction;

class MarsRoverControlSystem implements MarsRoverControlSystemInterface
{
    public function __construct(private readonly MarsRoverInterface $marsRover) 
    {
    }

    public function sendCommands(array $commandValues): array
    {
        $commandResults = [];

        foreach($commandValues as $commandValue) 
        {
            $command = Command::getEnum($commandValue);

            if(!Command::isValid($command->value)) {
                $commandResults[] = new CommandResult($command, $this->marsRover->getPosition(), false);
                continue;
            }

            switch($command) 
            {
                case Command::MOVE_FORWARD:
                    $positionResult = $this->marsRover->moveForward();
                    break;
    
                case Command::MOVE_BACKWARD:
                    $positionResult = $this->marsRover->moveBackward();
                    break;
    
                case Command::ROTATE_LEFT:
                    $positionResult = $this->marsRover->rotateLeft();
                    break;
    
                case Command::ROTATE_RIGHT:
                    $positionResult = $this->marsRover->rotateRight();
                    break;
            }

            $commandResults[] = new CommandResult($command, $positionResult->position, $positionResult->success);
        }

        return $commandResults;
    }

    public function wrap(): array
    {
        $commandResults = [];
        $initialPosition = $this->marsRover->getPosition();

        do {
            $positionResult = $this->marsRover->moveForward();

            $commandResults[] = new CommandResult(
                Command::MOVE_FORWARD, 
                $positionResult->position, 
                $positionResult->success
            );
            
        } while($positionResult->position != $initialPosition && $positionResult->success != false);

        return $commandResults;
    }

    public function setPosition(Position $position): bool
    {
        return $this->marsRover->setPosition($position);
    }

    public function getPosition(): Position
    {
        return $this->marsRover->getPosition();
    }
}
