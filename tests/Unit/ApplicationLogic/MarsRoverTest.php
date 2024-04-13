<?php

namespace Tests\Unit\ApplicationLogic;

use App\ApplicationLogic\MarsRover;
use App\Data\ObstacleData;
use App\Data\PositionDataBuilder;
use App\Enums\Direction;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Exception;
use Tests\TestCase;

class MarsRoverTest extends TestCase
{
    private static int $totalParallels;
    private static int $totalMeridians;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$totalParallels = 20;
        self::$totalMeridians = 10;
    }

    public function test_moveForwardNorthInsidePlanisphereWithoutObstacles_getUpdatedPosition(): void
    {
        $x = rand(0, self::$totalMeridians - 1);
        $y = rand(1, self::$totalParallels - 1);
        $direction = Direction::NORTH;

        $initialPosition = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();

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

        $expectedPosition = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y - 1)
            ->setDirection($direction)
            ->build();

        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardNorthInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::$totalMeridians - 1);
        $y = rand(1, self::$totalParallels - 1);
        $direction = Direction::NORTH;

        $initialPosition = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();

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
        $x = rand(0, self::$totalMeridians - 1);
        $y = rand(1, self::$totalParallels - 1);
        $direction = Direction::SOUTH;

        $initialPosition = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();

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

        $expectedPosition = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y + 1)
            ->setDirection($direction)
            ->build();

        $this->assertEquals($expectedPosition, $marsRover->getPosition());
    }

    public function test_moveForwardSouthInsidePlanisphereWithObstacle_throwsException(): void
    {
        $x = rand(0, self::$totalMeridians - 1);
        $y = rand(1, self::$totalParallels - 1);
        $direction = Direction::SOUTH;

        $initialPosition = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();

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
