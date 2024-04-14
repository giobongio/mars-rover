<?php

namespace Tests\Feature\ApplicationLogic;

use App\ApplicationLogic\MarsRover;
use App\Data\PositionResult;
use App\Data\Obstacle;
use App\Data\Position;
use App\Enums\Direction;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Exception;
use Tests\TestCase;

class MarsRoverTest extends TestCase
{
    private const TOTAL_PARALLELS = 100;
    private const TOTAL_MERIDIANS = 100;

    public function setUp(): void
    {
        parent::setUp();

        config(['app.planisphere.total_parallels' => self::TOTAL_PARALLELS]);
        config(['app.planisphere.total_meridians' => self::TOTAL_MERIDIANS]);
    }

    // Move forward 

    public function test_moveForwardNorthInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        $expectedPosition = new Position($x, $y - 1, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardNorthAtNorthPole_getNewPosition(): void
    {
        $x = 1;
        $y = 0;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        // The expected position is voluntarily fixed to avoid any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_MERIDIANS constant
        $expectedPosition = new Position(51, 1, Direction::SOUTH);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardSouthInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 2);
        $direction = Direction::SOUTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        $expectedPosition = new Position($x, $y + 1, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardSouthAtSouthPole_getNewPosition(): void
    {
        $x = 2;
        $y = self::TOTAL_PARALLELS - 1;
        $direction = Direction::SOUTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        // The expected position is voluntarily fixed to avoid any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_MERIDIANS constant
        $expectedPosition = new Position(52, 98, Direction::NORTH);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardEastInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 3);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        $expectedPosition = new Position(($x + 1) % (self::TOTAL_MERIDIANS - 1), $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardEastAtEastBorder_getNewPosition(): void
    {
        $x = self::TOTAL_MERIDIANS - 1;
        $y = 3;
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        // The expected position is voluntarily fixed to avoid any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_PARALLELS constant
        $expectedPosition = new Position(1, 3, Direction::EAST);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardWestInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(1, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        $expectedPosition = new Position($x - 1, $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveForwardWestAtWestBorder_getNewPosition(): void
    {
        $x = 0;
        $y = 2;
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        // The expected position is voluntarily fixed to avoid any calculation (which could be error prone)
        // Remember to update it if you change the self::TOTAL_PARALLELS constant
        $expectedPosition = new Position(98, 2, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    // Move backward 

    public function test_moveBackwardNorthInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 2);
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position($x, $y + 1, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveBackwardNorthAtSouthPole_getNewPosition(): void
    {
        $x = 2;
        $y = self::TOTAL_PARALLELS - 1;
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position(ceil(($x + self::TOTAL_MERIDIANS / 2) % self::TOTAL_MERIDIANS), self::TOTAL_PARALLELS - 2, Direction::SOUTH);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveBackwardSouthInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::SOUTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position($x, $y - 1, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveBackwardSouthAtNorthPole_getNewPosition(): void
    {
        $x = 1;
        $y = 0;
        $direction = Direction::SOUTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position(floor(($x + self::TOTAL_MERIDIANS / 2) % self::TOTAL_MERIDIANS), 1, Direction::NORTH);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveBackwardEastInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(1, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position($x - 1, $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }


    public function test_moveBackwardEastAtWestBorder_getNewPosition(): void
    {
        $x = 0;
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position(self::TOTAL_PARALLELS - 2, $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_moveBackwardWestInsidePlanisphere_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 3);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position(($x + 1) % (self::TOTAL_MERIDIANS - 1), $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }


    public function test_moveBackwardWestAtEastBorder_getNewPosition(): void
    {
        $x = self::TOTAL_MERIDIANS - 1;
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position(1, $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    // Move with obstacle 
    
    public function test_moveForwardWithObstacle_getError(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(1, self::TOTAL_PARALLELS - 1);
        $direction = Direction::NORTH;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new Obstacle($x, $y - 1)
            ]);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveForward();

        $expectedPosition = new Position($x, $y - 1, $direction);
        $expectedResult = new PositionResult($expectedPosition, false);
        
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function test_moveBackwardWithObstacle_getError(): void
    {
        $x = rand(1, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);

        $obstacleRepository = $this->createMock(ObstacleRepository::class);
        $obstacleRepository->method('getAll')
            ->willReturn([
                new Obstacle($x - 1, $y)
            ]);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->moveBackward();

        $expectedPosition = new Position($x - 1, $y, $direction);
        $expectedResult = new PositionResult($expectedPosition, false);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    // Rotate left

    public function test_rotateLeft_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::EAST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->rotateLeft();

        $expectedPosition = new Position($x, $y, Direction::NORTH);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    // Rotate right

    public function test_rotateRight_getNewPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $actualResult = $marsRover->rotateRight();

        $expectedPosition = new Position($x, $y, Direction::NORTH);
        $expectedResult = new PositionResult($expectedPosition, true);
        
        $this->assertEquals($expectedResult, $actualResult);
    }

    // Position

    public function test_moveForwardWithUndefinedPosition_throwsException(): void
    {
        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->moveForward();
    }

    public function test_moveBackwardWithUndefinedPosition_throwsException(): void
    {
        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->moveBackward();
    }

    public function test_rotateLeftWithUndefinedPosition_throwsException(): void
    {
        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->rotateLeft();
    }

    public function test_rotateRightWithUndefinedPosition_throwsException(): void
    {
        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $this->expectException(Exception::class);
        $marsRover->rotateRight();
    }

    public function test_setPosition_getExpectedPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $expectedPosition = new Position($x, $y, $direction);

        $marsRover->setPosition($expectedPosition);
        $actualPosition = $marsRover->getPosition();

        $this->assertEquals($expectedPosition, $actualPosition);
    }

    // Last position

    public function test_construct_getLastPosition(): void
    {
        $x = rand(0, self::TOTAL_MERIDIANS - 1);
        $y = rand(0, self::TOTAL_PARALLELS - 1);
        $direction = Direction::WEST;

        $positionRepository = $this->createMock(PositionRepository::class);
        $obstacleRepository = $this->createMock(ObstacleRepository::class);

        $marsRover = new MarsRover(
            $positionRepository,
            $obstacleRepository
        );

        $expectedPosition = new Position($x, $y, $direction);

        $marsRover->setPosition($expectedPosition);
        $actualPosition = $marsRover->getPosition();

        $this->assertEquals($expectedPosition, $actualPosition);
    }
}
