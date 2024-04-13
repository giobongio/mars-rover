<?php

namespace Tests\Unit\Data;

use App\Data\PositionData;
use App\Enums\RoverDirection;
use Tests\TestCase;

class PositionDataTest extends TestCase
{
    public function test_serialize_outputSerializedData(): void
    {
        $pointX = 20;
        $pointY = 30;
        $roverDirection = RoverDirection::WEST;

        $positionData = new PositionData(
            $pointX,
            $pointY,
            $roverDirection
        );

        $expectedPositionData = '{"pointX":' . $pointX . ',"pointY":' . $pointY . ',"roverDirection":"' . RoverDirection::getValue($roverDirection) . '"}';
        $this->assertEquals($expectedPositionData, $positionData->jsonSerialize());
    }
}
