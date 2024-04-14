<?php

namespace Tests\Unit\Data;

use App\Data\Position;
use App\Enums\Direction;
use Tests\TestCase;
use InvalidArgumentException;

class PositionTest extends TestCase
{
    public function test_xInvalid_throwsInvalidArgumentException(): void
    {
        $x = -1;
        $y = 30;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);
        $position = new Position($x, $y, $direction);
    }

    public function test_yInvalid_throwsInvalidArgumentException(): void
    {
        $x = 20;
        $y = -1;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);
        $position = new Position($x, $y, $direction);
    }

    public function test_allDataValid_correctPositionCreated(): void
    {
        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $position = new Position($x, $y, $direction);

        $this->assertEquals($x, $position->x);
        $this->assertEquals($y, $position->y);
        $this->assertEquals($direction, $position->direction);
    }
}
