<?php

namespace Tests\Unit\Data;

use App\Data\PositionDataBuilder;
use App\Enums\RoverDirection;
use InvalidArgumentException;
use Tests\TestCase;

class PositionDataBuilderTest extends TestCase
{
    public function test_pointXInvalid_throwsInvalidArgumentException(): void
    {
        $pointX = -1;
        $pointY = 30;
        $roverDirection = RoverDirection::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_pointXMissing_throwsInvalidArgumentException(): void
    {
        $pointY = 30;
        $roverDirection = RoverDirection::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_pointYInvalid_throwsInvalidArgumentException(): void
    {
        $pointX = 20;
        $pointY = -1;
        $roverDirection = RoverDirection::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_pointYMissing_throwsInvalidArgumentException(): void
    {
        $pointX = 20;
        $roverDirection = RoverDirection::WEST;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setRoverDirection($roverDirection)
            ->build();
    }

    public function test_roverDirectionMissing_throwsInvalidArgumentException(): void
    {
        $pointX = 20;
        $pointY = 30;

        $this->expectException(InvalidArgumentException::class);

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->build();
    }

    public function test_allDataValid_correctPositionDataCreated(): void
    {
        $pointX = 20;
        $pointY = 30;
        $roverDirection = RoverDirection::WEST;

        $positionData = (new PositionDataBuilder())
            ->setPointX($pointX)
            ->setPointY($pointY)
            ->setRoverDirection($roverDirection)
            ->build();

        $this->assertEquals($pointX, $positionData->pointX);
        $this->assertEquals($pointY, $positionData->pointY);
        $this->assertEquals($roverDirection, $positionData->roverDirection);
    }
}
