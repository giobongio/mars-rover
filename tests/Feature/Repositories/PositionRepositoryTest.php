<?php
 
namespace Tests\Feature\Repositories;
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\Direction;
use App\Repositories\PositionRepository;
use App\Data\PositionData;
use Tests\TestCase;
 
class PositionRepositoryTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_savePositionData_getSamePositionData(): void
    {
        $x = 200;
        $y = 300;
        $direction = Direction::WEST;

        $positionData = new PositionData(
            $x,
            $y,
            $direction
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($positionData);

        $actualData = $positionRepository->get(1);
        $this->assertEquals($positionData, $actualData);
    }
 
    public function test_deletePositionData_getNull(): void
    {
        $x = 200;
        $y = 300;
        $direction = Direction::WEST;

        $positionData = new PositionData(
            $x,
            $y,
            $direction
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($positionData);
        $positionRepository->delete(1);

        $actualData = $positionRepository->get(1);
        $this->assertEmpty($actualData);
    }
}