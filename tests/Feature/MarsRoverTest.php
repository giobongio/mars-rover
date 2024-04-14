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
    private const TOTAL_PARALLELS = 100;
    private const TOTAL_MERIDIANS = 100;

    // Move forward 

    public function test_moveForwardNorthInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::NORTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData($x, $y - 1, $direction);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardNorthAtNorthPole_getNewPosition(): void
    {
        $x = 1;
        $y = 0;
        $direction = Direction::NORTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData(floor(($x + self::TOTAL_MERIDIANS / 2) % self::TOTAL_MERIDIANS), 1, Direction::SOUTH);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardSouthInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 2);
        $direction = Direction::SOUTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData($x, $y + 1, $direction);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardSouthAtSouthPole_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = self::TOTAL_PARALLELS - 1;
        $direction = Direction::SOUTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData(ceil(($x + self::TOTAL_MERIDIANS / 2) % self::TOTAL_MERIDIANS), 1, Direction::SOUTH);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardEastInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 2);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData($x + 1, $y, $direction);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardWestInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(1, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->moveForward();

        $expectedPosition = new PositionData($x - 1, $y, $direction);
        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardWithObstacle_throwsException(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 2);
        $direction = Direction::NORTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new ObstacleData($x, $y - 1)
            ]);

        $marsRover = new MarsRover(
            self::TOTAL_PARALLELS,
            self::TOTAL_MERIDIANS,
            $initialPosition,
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->moveForward();
    }
}
