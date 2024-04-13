<?php

namespace Tests\Unit\Data;

use App\Data\PositionDataBuilder;
use App\Enums\Direction;
use InvalidArgumentException;
use Tests\TestCase;

class PositionDataBuilderTest extends TestCase
{
    public function test_xInvalid_throwsInvalidArgumentException(): void
    {
        $x = -1;
        $y = 30;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();
    }

    public function test_xMissing_throwsInvalidArgumentException(): void
    {
        $y = 30;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setY($y)
            ->setDirection($direction)
            ->build();
    }

    public function test_yInvalid_throwsInvalidArgumentException(): void
    {
        $x = 20;
        $y = -1;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();
    }

    public function test_yMissing_throwsInvalidArgumentException(): void
    {
        $x = 20;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setX($x)
            ->setDirection($direction)
            ->build();
    }

    public function test_directionMissing_throwsInvalidArgumentException(): void
    {
        $x = 20;
        $y = 30;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->build();
    }

    public function test_allDataValid_correctPositionDataCreated(): void
    {
        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $positionData = (new PositionDataBuilder())
            ->setX($x)
            ->setY($y)
            ->setDirection($direction)
            ->build();

        $this->assertEquals($x, $positionData->x);
        $this->assertEquals($y, $positionData->y);
        $this->assertEquals($direction, $positionData->direction);
    }
}
