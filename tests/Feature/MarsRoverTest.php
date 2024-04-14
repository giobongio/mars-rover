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

    public function test_moveForwardNorthInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
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

    public function test_moveForwardNorthAtNorthPoleWithoutObstacles_getUpdatedPosition(): void
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

        $expectedPosition = new PositionData($x + self::TOTAL_MERIDIANS / 2, 1, Direction::SOUTH);
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

    public function test_moveForwardSouthInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
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

    public function test_moveForwardSouthInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::SOUTH;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new ObstacleData($x, $y + 1)
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

    public function test_moveForwardEastInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
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

    public function test_moveForwardEastInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new ObstacleData($x + 1, $y)
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

    public function test_moveForwardWestInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
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

    public function test_moveForwardWestInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $initialPosition = new PositionData($x, $y, $direction);

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new ObstacleData($x - 1, $y)
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
