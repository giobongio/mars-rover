<?php

namespace Tests\Feature;

use App\ApplicationLogic\MarsRover;
use App\ApplicationLogic\MarsRoverControlSystem;
use App\Data\CommandResult;
use App\Data\Position;
use App\Data\Obstacle;
use App\Enums\Direction;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Tests\TestCase;

class MarsRoverControlSystemTest extends TestCase
{
    private const TOTAL_PARALLELS = 100;
    private const TOTAL_MERIDIANS = 100;

    public function setUp(): void
    {
        parent::setUp();

        config(['app.planisphere.total_parallels' => self::TOTAL_PARALLELS]);
        config(['app.planisphere.total_meridians' => self::TOTAL_MERIDIANS]);
    }

    public function test_sendCommands_getCommandResults(): void
    {
        $x = 10;
        $y = 20;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $commands = 'flrb';
        $actualResult = $marsRoverControlSystem->sendCommands($commands);

        $expectedResult = [
            new CommandResult($commands[0], new Position(10, 19, Direction::NORTH), true),
            new CommandResult($commands[1], new Position(10, 19, Direction::WEST), true),
            new CommandResult($commands[2], new Position(10, 19, Direction::NORTH), true),
            new CommandResult($commands[3], new Position(10, 20, Direction::NORTH), true),
        ];
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_sendCommandsWithObstacles_getCommandResults(): void
    {
        $x = 10;
        $y = 20;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new Obstacle(10, 18)
            ]);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $commands = 'fflrb';
        $actualResult = $marsRoverControlSystem->sendCommands($commands);

        $expectedResult = [
            new CommandResult($commands[0], new Position(10, 19, Direction::NORTH), true),
            new CommandResult($commands[1], new Position(10, 18, Direction::NORTH), false),
            new CommandResult($commands[2], new Position(10, 19, Direction::WEST), true),
            new CommandResult($commands[3], new Position(10, 19, Direction::NORTH), true),
            new CommandResult($commands[4], new Position(10, 20, Direction::NORTH), true),
        ];
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_setPosition_getExpectedPosition(): void
    {
        $x = 10;
        $y = 20;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new Obstacle(10, 18)
            ]);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);
        $expectedPosition = new Position($x, $y, $direction);
        
        $marsRoverControlSystem->setPosition($expectedPosition);
        $actualPosition = $marsRover->getPosition();

        $this->assertEquals($expectedPosition, $actualPosition);
    }
}
