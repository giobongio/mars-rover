<?php

namespace Tests\Unit;

use App\Data\PositionData;
use Tests\TestCase;

class PositionDataTest extends TestCase
{
    public function test_serialize_outputSerializedData()
    {
        $pointX = 20;
        $pointY = 30;
        $roverDirection = "W";

        $positionData = new PositionData(
            $pointX,
            $pointY,
            $roverDirection
        );

        $expectedPositionData = '{"pointX":' . $pointX . ',"pointY":' . $pointY . ',"roverDirection":"' . $roverDirection . '"}';
        $this->assertEquals($expectedPositionData, $positionData->jsonSerialize());
    }
}
