<?php

namespace App\ApplicationLogic;

use App\Data\Position;
use App\Enums\Direction;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Exception;

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
        $this->obstacles = $obstacleRepository->getAll();
    }

    public function moveForward(): void
    {
        switch($this->position->direction) 
        {
            case Direction::NORTH:
                $newPosition = $this->decrementY();
                $this->obstacleCheck($newPosition->x, $newPosition->y);
                $this->position = $newPosition;
                break;

            case Direction::SOUTH:
                $newPosition = $this->incrementY();
                $this->obstacleCheck($newPosition->x, $newPosition->y);
                $this->position = $newPosition;
                break;

            case Direction::EAST:
                $x = $this->position->x + 1;
                $this->obstacleCheck($x, $this->position->y);
                $this->position->x = $x;
                break;

            case Direction::WEST:
                $x = $this->position->x - 1;
                $this->obstacleCheck($x, $this->position->y);
                $this->position->x = $x;
                break;
        }
    }

    public function moveBackward(): void
    {
    }

    public function rotateLeft(): void
    {
    }

    public function rotateRight(): void
    {
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    private function obstacleCheck(int $x, int $y): void
    {
        foreach($this->obstacles as $obstacle) {
            if($obstacle->x == $x && $obstacle->y == $y) {
                throw new Exception('Obstacle found at (x, y) = ('. $x . ',' . $y .'), cannot proceed.');
            }
        }
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

        // Increment the Y value, because now we are in the opposite part of the globe
        $position->y--;

        // Since now we are in the opposite part of the globe, we need to invert the direction where we are oriented
        $position->direction = ($position->direction == Direction::NORTH) ? Direction::SOUTH : Direction::NORTH;

        return $position;
    }
}
