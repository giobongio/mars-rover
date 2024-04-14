<?php

namespace App\ApplicationLogic;

use App\Data\Position;
use App\Data\CommandResult;
use App\Enums\Direction;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;

class MarsRover
{
    private readonly array $obstacles;

    public function __construct(
        private readonly int $totalParallels,
        private readonly int $totalMeridians,
        private Position $position,
        private readonly PositionRepository $positionRepository,
        private readonly ObstacleRepository $obstacleRepository
    ) {

        // Get obstacles in memory to perform faster than querying the repository
        $this->obstacles = $obstacleRepository->getAll();
    }

    public function moveForward(): CommandResult
    {
        switch($this->position->direction) 
        {
            case Direction::NORTH:
                $newPosition = $this->decrementY();
                break;

            case Direction::SOUTH:
                $newPosition = $this->incrementY();
                break;

            case Direction::EAST:
                $newPosition = $this->incrementX();
                break;

            case Direction::WEST:
                $newPosition = $this->decrementX();
                break;
        }

        if($this->existsObstacle($newPosition->x, $newPosition->y)) {
            return new CommandResult($newPosition, false);
        }

        $this->positionRepository->save($newPosition);
        $this->position = $newPosition;

        return new CommandResult($newPosition, true);
    }

    public function moveBackward(): CommandResult
    {
        switch($this->position->direction) 
        {
            case Direction::NORTH:
                $newPosition = $this->incrementY();
                break;

            case Direction::SOUTH:
                $newPosition = $this->decrementY();
                break;

            case Direction::EAST:
                $newPosition = $this->decrementX();
                break;

            case Direction::WEST:
                $newPosition = $this->incrementX();
                break;
        }

        if($this->existsObstacle($newPosition->x, $newPosition->y)) {
            return new CommandResult($newPosition, false);
        }

        $this->positionRepository->save($newPosition);
        $this->position = $newPosition;

        return new CommandResult($newPosition, true);
    }

    public function rotateLeft(): CommandResult
    {
        $newPosition = $this->position;
        return new CommandResult($newPosition, true);
    }

    public function rotateRight(): CommandResult
    {
        $newPosition = $this->position;
        return new CommandResult($newPosition, true);
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    private function incrementX(): Position
    {
        $position = new Position(
            $this->position->x, 
            $this->position->y, 
            $this->position->direction
        );

        // Increment the X value, and calculate module if we are wrapping the planisphere
        $position->x = ($position->x + 1) % ($this->totalMeridians - 1);

        return $position;
    }

    private function incrementY(): Position
    {
        $position = new Position(
            $this->position->x, 
            $this->position->y, 
            $this->position->direction
        );

        // If we are inside the planisphere, simply increment the Y value
        if($position->y < $this->totalParallels - 1) {
            $position->y++;
            return $position;
        }

        // Else we are at the South Pole, aiming going even further south

        // Calculate the antimeridian (approximate to the upper integer, in case we have odd total meridians)
        $position->x = ceil(($position->x + $this->totalMeridians / 2) % $this->totalMeridians);

        // Decrement the Y value, because now we are in the opposite part of the globe
        $position->y--;

        // Since now we are in the opposite part of the globe, we need to invert the direction where we are oriented
        $position->direction = ($position->direction == Direction::NORTH) ? Direction::SOUTH : Direction::NORTH;

        return $position;
    }

    private function decrementX(): Position
    {
        $position = new Position(
            $this->position->x, 
            $this->position->y, 
            $this->position->direction
        );

        // Decrement the X value, and calculate module if we are wrapping the planisphere
        $position->x = ($position->x - 1 + ($this->totalMeridians - 1)) % ($this->totalMeridians - 1);

        return $position;
    }

    private function decrementY(): Position
    {
        $position = new Position(
            $this->position->x, 
            $this->position->y, 
            $this->position->direction
        );

        // If we are inside the planisphere, simply decrement the Y value
        if($position->y > 0) {
            $position->y--;
            return $position;
        }

        // Else we are at the North Pole, aiming going even further north

        // Calculate the antimeridian (approximate to the lower integer, in case we have odd total meridians)
        $position->x = floor(($position->x + $this->totalMeridians / 2) % $this->totalMeridians);

        // Increment the Y value, because now we are in the opposite part of the globe
        $position->y++;

        // Since now we are in the opposite part of the globe, we need to invert the direction where we are oriented
        $position->direction = ($position->direction == Direction::NORTH) ? Direction::SOUTH : Direction::NORTH;

        return $position;
    }

    private function existsObstacle(int $x, int $y): bool
    {
        foreach($this->obstacles as $obstacle) {
            if($obstacle->x == $x && $obstacle->y == $y) {
                return true;
            }
        }

        return false;
    }
}
