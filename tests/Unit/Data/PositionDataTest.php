<?php

namespace Tests\Unit\Data;

use App\Data\PositionData;
use App\Enums\Direction;
use Tests\TestCase;
use InvalidArgumentException;

class PositionDataTest extends TestCase
{
    public function test_xInvalid_throwsInvalidArgumentException(): void
    {
        $x = -1;
        $y = 30;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);
        $positionData = new PositionData($x, $y, $direction);
    }

    public function test_yInvalid_throwsInvalidArgumentException(): void
    {
        $x = 20;
        $y = -1;
        $direction = Direction::WEST;

        $this->expectException(InvalidArgumentException::class);
        $positionData = new PositionData($x, $y, $direction);
    }

    public function test_allDataValid_correctPositionDataCreated(): void
    {
        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $positionData = new PositionData($x, $y, $direction);

        $this->assertEquals($x, $positionData->x);
        $this->assertEquals($y, $positionData->y);
        $this->assertEquals($direction, $positionData->direction);
    }

    public function test_serialize_outputSerializedData(): void
    {
        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $positionData = new PositionData(
            $x,
            $y,
            $direction
        );

        $expectedPositionData = '{"x":' . $x . ',"y":' . $y . ',"direction":"' . $direction->value . '"}';
        $this->assertEquals($expectedPositionData, $positionData->jsonSerialize());
    }
}
