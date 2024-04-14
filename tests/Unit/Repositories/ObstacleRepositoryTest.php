<?php
 
namespace Tests\Unit\Repositories;
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\ObstacleRepository;
use App\Data\Obstacle;
use Tests\TestCase;
 
class ObstacleRepositoryTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_saveObstacle_getSameObstacle(): void
    {
        $x = 20;
        $y = 30;

        $obstacle = new Obstacle(
            $x,
            $y
        );

        $obstacleRepository = new ObstacleRepository();
        $obstacleRepository->save($obstacle);

        $actualData = $obstacleRepository->get(1);
        $this->assertEquals($obstacle, $actualData);
    }
 
    public function test_deleteObstacle_getNull(): void
    {
        $x = 20;
        $y = 30;

        $obstacle = new Obstacle(
            $x,
            $y
        );

        $obstacleRepository = new ObstacleRepository();
        $obstacleRepository->save($obstacle);
        $obstacleRepository->delete(1);

        $actualData = $obstacleRepository->get(1);
        $this->assertEmpty($actualData);
    }
}