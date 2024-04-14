<?php

namespace Tests\Feature;

use App\ApplicationLogic\MarsRover;
use App\Data\ObstacleData;
use App\Data\PositionData;
use App\Enums\Direction;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Exception;
use Tests\TestCase;

class MarsRoverTest extends TestCase
{
    private const TOTAL_PARALLELS = 20;
    private const TOTAL_MERIDIANS = 10;

    public function test_moveForwardNorthInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::NORTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->expects(self::any())
            ->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData($x, $y-1, $direction);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardNorthInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::NORTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->expects(self::any())
            ->method('getAll')
            ->willReturn([
                new ObstacleData($x, $y - 1)
            ]);

        $marsRover = new MarsRover(
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->moveForward();
    }

    public function test_moveForwardSouthInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::SOUTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->expects(self::any())
            ->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData($x, $y + 1, $direction);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardSouthInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::SOUTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->expects(self::any())
            ->method('getAll')
            ->willReturn([
                new ObstacleData($x, $y + 1)
            ]);

        $marsRover = new MarsRover(
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->moveForward();
    }
}
