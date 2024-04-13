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
        private PositionData $positionData,
        private readonly PositionRepository $positionRepository,
        private readonly ObstacleRepository $obstacleRepository
    ) {
        $this->obstacles = $obstacleRepository->getAll();
    }

    public function moveForward(): void
    {
        switch($this->positionData->direction) {
            case Direction::NORTH:
                $y = $this->positionData->y - 1;
                $this->obstacleCheck($this->positionData->x, $y);
                $this->positionData->y = $y;
                break;

            case Direction::SOUTH:
                $y = $this->positionData->y + 1;
                $this->obstacleCheck($this->positionData->x, $y);
                $this->positionData->y = $y;
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
}
