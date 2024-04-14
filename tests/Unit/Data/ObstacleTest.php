<?php

namespace Tests\Unit\Data;

use App\Data\Obstacle;
use Tests\TestCase;
use InvalidArgumentException;

class ObstacleTest extends TestCase
{
    public function test_xInvalid_throwsInvalidArgumentException(): void
    {
        $x = -1;
        $y = 30;

        $this->expectException(InvalidArgumentException::class);
        new Obstacle($x, $y);
    }

    public function test_yInvalid_throwsInvalidArgumentException(): void
    {
        $x = 20;
        $y = -1;

        $this->expectException(InvalidArgumentException::class);
        new Obstacle($x, $y);
    }

    public function test_allDataValid_correctObstacleCreated(): void
    {
        $x = 20;
        $y = 30;

        $obstacle = new Obstacle($x, $y);

        $this->assertEquals($x, $obstacle->x);
        $this->assertEquals($y, $obstacle->y);
    }
}
