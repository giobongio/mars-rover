<?php
 
namespace Tests\Feature\Repositories;
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\RoverDirection;
use App\Repositories\PositionRepository;
use App\Data\PositionData;
use Tests\TestCase;
 
class PositionRepositoryTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_savePositionData_getSamePositionData(): void
    {
        $pointX = 200;
        $pointY = 300;
        $roverDirection = RoverDirection::WEST;

        $positionData = new PositionData(
            $pointX,
            $pointY,
            $roverDirection
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($positionData);

        $actualData = $positionRepository->get(1);
        $this->assertEquals($positionData, $actualData);
    }
 
    public function test_deletePositionData_getNull(): void
    {
        $pointX = 200;
        $pointY = 300;
        $roverDirection = RoverDirection::WEST;

        $positionData = new PositionData(
            $pointX,
            $pointY,
            $roverDirection
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($positionData);
        $positionRepository->delete(1);

        $actualData = $positionRepository->get(1);
        $this->assertEquals(null, $actualData);
    }
}