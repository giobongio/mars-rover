<?php
 
namespace Tests\Unit\Repositories;
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\ObstacleRepository;
use App\Data\ObstacleData;
use Tests\TestCase;
 
class ObstacleRepositoryTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_saveObstacleData_getSameObstacleData(): void
    {
        $x = 20;
        $y = 30;

        $obstacleData = new ObstacleData(
            $x,
            $y
        );

        $obstacleRepository = new ObstacleRepository();
        $obstacleRepository->save($obstacleData);

        $actualData = $obstacleRepository->get(1);
        $this->assertEquals($obstacleData, $actualData);
    }
 
    public function test_deleteObstacleData_getNull(): void
    {
        $x = 20;
        $y = 30;

        $obstacleData = new ObstacleData(
            $x,
            $y
        );

        $obstacleRepository = new ObstacleRepository();
        $obstacleRepository->save($obstacleData);
        $obstacleRepository->delete(1);

        $actualData = $obstacleRepository->get(1);
        $this->assertEmpty($actualData);
    }
}