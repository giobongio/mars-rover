<?php
 
namespace Tests\Unit\Repositories;
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\Direction;
use App\Repositories\PositionRepository;
use App\Data\Position;
use Tests\TestCase;
 
class PositionRepositoryTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_savePosition_getSamePosition(): void
    {
        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $position = new Position(
            $x,
            $y,
            $direction
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($position);

        $actualData = $positionRepository->get(1);
        $this->assertEquals($position, $actualData);
    }
 
    public function test_deletePosition_getNull(): void
    {
        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $position = new Position(
            $x,
            $y,
            $direction
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($position);
        $positionRepository->delete(1);

        $actualData = $positionRepository->get(1);
        $this->assertEmpty($actualData);
    }
}