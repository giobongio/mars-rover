<?php

namespace Tests\Unit;

use App\Data\PositionDataBuilder;
use InvalidArgumentException;
use Tests\TestCase;

class PositionDataBuilderTest extends TestCase
{
    public function test_pointXInvalid_throwsInvalidArgumentException()
    {
        $id = 123;
        $pointX = -1;
        $pointY = 30;
        $roverDirection = "W";

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_pointXMissing_throwsInvalidArgumentException()
    {
        $id = 123;
        $pointY = 30;
        $roverDirection = "W";

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_pointYInvalid_throwsInvalidArgumentException()
    {
        $id = 123;
        $pointX = 20;
        $pointY = -1;
        $roverDirection = "W";

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_pointYMissing_throwsInvalidArgumentException()
    {
        $id = 123;
        $pointX = 20;
        $roverDirection = "W";

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_roverDirectionInvalid_throwsInvalidArgumentException()
    {
        $id = 123;
        $pointX = 20;
        $pointY = 30;
        $roverDirection = "X";

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_roverDirectionMissing_throwsInvalidArgumentException()
    {
        $id = 123;
        $pointX = 20;
        $pointY = 30;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->build();
    }

    public function test_allDataValid_correctPositionDataCreated()
    {
        $id = 123;
        $pointX = 20;
        $pointY = 30;
        $roverDirection = "W";

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();

        $this->assertEquals($id, $positionData->id);
        $this->assertEquals($pointX, $positionData->pointX);
        $this->assertEquals($pointY, $positionData->pointY);
        $this->assertEquals($roverDirection, $positionData->roverDirection);
    }
}
