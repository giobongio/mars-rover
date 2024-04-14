<?php

namespace Tests\Feature;

use App\ApplicationLogic\MarsRover;
use App\ApplicationLogic\MarsRoverControlSystem;
use App\Data\CommandResult;
use App\Data\Position;
use App\Data\Obstacle;
use App\Enums\Direction;
use App\Enums\Command;
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

    public function test_sendCommands_allCommandsSucceed(): void
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
            new CommandResult(Command::getEnum($commands[0]), new Position(10, 19, Direction::NORTH), true),
            new CommandResult(Command::getEnum($commands[1]), new Position(10, 19, Direction::WEST), true),
            new CommandResult(Command::getEnum($commands[2]), new Position(10, 19, Direction::NORTH), true),
            new CommandResult(Command::getEnum($commands[3]), new Position(10, 20, Direction::NORTH), true),
        ];
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_sendCommandsWithObstacles_someCommandsFail(): void
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
            new CommandResult(Command::getEnum($commands[0]), new Position(10, 19, Direction::NORTH), true),
            new CommandResult(Command::getEnum($commands[1]), new Position(10, 18, Direction::NORTH), false),
            new CommandResult(Command::getEnum($commands[2]), new Position(10, 19, Direction::WEST), true),
            new CommandResult(Command::getEnum($commands[3]), new Position(10, 19, Direction::NORTH), true),
            new CommandResult(Command::getEnum($commands[4]), new Position(10, 20, Direction::NORTH), true),
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

    public function test_wrapNorth_allCommandsSucceed(): void
    {
        $x = 10;
        $y = 1;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $actualResult = $marsRoverControlSystem->wrap();

        // The expected positions are voluntarily without any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_MERIDIANS constant
        $expectedResult = [];
        
        // Go up until North Pole
        $expectedResult[] = new CommandResult(Command::MOVE_FORWARD, new Position(10, 0, Direction::NORTH), true);

        // Go down until South Pole
        for($currentY = 1; $currentY <= self::TOTAL_PARALLELS - 1; $currentY++) {
            $expectedResult[] = new CommandResult(Command::MOVE_FORWARD, new Position(60, $currentY, Direction::SOUTH), true);
        }

        // Go up until initial position
        for($currentY = self::TOTAL_PARALLELS - 2; $currentY >= 1; $currentY--) {
            $expectedResult[] = new CommandResult(Command::MOVE_FORWARD, new Position(10, $currentY, Direction::NORTH), true);
        }
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_wrapNorthWithObstacles_continueUntilObstacle(): void
    {
        $x = 10;
        $y = 1;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new Obstacle(60, 2)
            ]);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $actualResult = $marsRoverControlSystem->wrap();

        // The expected positions are voluntarily without any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_MERIDIANS constant
        $expectedResult = [
            new CommandResult(Command::MOVE_FORWARD, new Position(10, 0, Direction::NORTH), true),
            new CommandResult(Command::MOVE_FORWARD, new Position(60, 1, Direction::SOUTH), true),
            new CommandResult(Command::MOVE_FORWARD, new Position(60, 2, Direction::SOUTH), false)
        ];
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_wrapEast_allCommandsSucceed(): void
    {
        $x = self::TOTAL_MERIDIANS - 2;
        $y = 3;
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $actualResult = $marsRoverControlSystem->wrap();

        // The expected positions are voluntarily without any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_MERIDIANS constant
        $expectedResult = [];
        
        $expectedResult[] = new CommandResult(Command::MOVE_FORWARD, new Position(0, 3, Direction::EAST), true);

        for($currentX = 1; $currentX <= self::TOTAL_MERIDIANS - 2; $currentX++) {
            $expectedResult[] = new CommandResult(Command::MOVE_FORWARD, new Position($currentX, 3, Direction::EAST), true);
        }
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_wrapEastWithObstacles_continueUntilObstacle(): void
    {
        $x = self::TOTAL_MERIDIANS - 2;
        $y = 3;
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new Obstacle(2, 3)
            ]);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $actualResult = $marsRoverControlSystem->wrap();

        // The expected positions are voluntarily without any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_MERIDIANS constant
        $expectedResult = [
            new CommandResult(Command::MOVE_FORWARD, new Position(0, 3, Direction::EAST), true),
            new CommandResult(Command::MOVE_FORWARD, new Position(1, 3, Direction::EAST), true),
            new CommandResult(Command::MOVE_FORWARD, new Position(2, 3, Direction::EAST), false),
        ];
        
        $this->assertEquals($expectedResult, $actualResult);
    }
}
