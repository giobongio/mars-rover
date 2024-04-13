<?php

namespace Tests\Unit\Data;

use App\Data\PositionData;
use App\Enums\Direction;
use Tests\TestCase;

class PositionDataTest extends TestCase
{
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
