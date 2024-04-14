<?php

namespace App\ApplicationLogic;

use App\Data\PositionData;
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
        private PositionData $positionData,
        private readonly PositionRepository $positionRepository,
        private readonly ObstacleRepository $obstacleRepository
    ) {
        $this->obstacles = $obstacleRepository->getAll();
    }

    public function moveForward(): void
    {
        switch($this->positionData->direction) 
        {
            case Direction::NORTH:
                $newPositionData = $this->decrementY();
                $this->obstacleCheck($newPositionData->x, $newPositionData->y);
                $this->positionData = $newPositionData;
                break;

            case Direction::SOUTH:
                $newPositionData = $this->incrementY();
                $this->obstacleCheck($newPositionData->x, $newPositionData->y);
                $this->positionData = $newPositionData;
                break;

            case Direction::EAST:
                $x = $this->positionData->x + 1;
                $this->obstacleCheck($x, $this->positionData->y);
                $this->positionData->x = $x;
                break;

            case Direction::WEST:
                $x = $this->positionData->x - 1;
                $this->obstacleCheck($x, $this->positionData->y);
                $this->positionData->x = $x;
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

    public function getPosition(): PositionData
    {
        return $this->positionData;
    }

    private function obstacleCheck(int $x, int $y): void
    {
        foreach($this->obstacles as $obstacle) {
            if($obstacle->x == $x && $obstacle->y == $y) {
                throw new Exception('Obstacle found at (x, y) = ('. $x . ',' . $y .'), cannot proceed.');
            }
        }
    }

    private function decrementY(): PositionData
    {
        $positionData = new PositionData(
            $this->positionData->x, 
            $this->positionData->y, 
            $this->positionData->direction
        );

        // If we are inside the planisphere, simply decrement the Y value
        if($positionData->y > 0) {
            $positionData->y--;
            return $positionData;
        }

        // Else we are at the North Pole, aiming going even further north

        // Calculate the antimeridian (approximate to the lower integer, in case we have odd total meridians)
        $positionData->x = floor(($positionData->x + $this->totalMeridians / 2) % $this->totalMeridians);

        // Increment the Y value, because now we are in the opposite part of the globe
        $positionData->y++;

        // Since now we are in the opposite part of the globe, we need to invert the direction where we are oriented
        $positionData->direction = ($positionData->direction == Direction::NORTH) ? Direction::SOUTH : Direction::NORTH;

        return $positionData;
    }

    private function incrementY(): PositionData
    {
        $positionData = new PositionData(
            $this->positionData->x, 
            $this->positionData->y, 
            $this->positionData->direction
        );

        // If we are inside the planisphere, simply increment the Y value
        if($positionData->y < $this->totalParallels - 1) {
            $positionData->y++;
            return $positionData;
        }

        // Else we are at the South Pole, aiming going even further south

        // Calculate the antimeridian (approximate to the upper integer, in case we have odd total meridians)
        $positionData->x = ceil(($positionData->x + $this->totalMeridians / 2) % $this->totalMeridians);

        // Increment the Y value, because now we are in the opposite part of the globe
        $positionData->y--;

        // Since now we are in the opposite part of the globe, we need to invert the direction where we are oriented
        $positionData->direction = ($positionData->direction == Direction::NORTH) ? Direction::SOUTH : Direction::NORTH;

        return $positionData;
    }
}
