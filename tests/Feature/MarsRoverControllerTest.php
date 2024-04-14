<?php

namespace Tests\Feature;

use App\ApplicationLogic\MarsRover;
use App\ApplicationLogic\MarsRoverControlSystem;
use App\Data\CommandResult;
use App\Data\Position;
use App\Data\Obstacle;
use App\Enums\Direction;
use App\Enums\Command;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Tests\TestCase;

class MarsRoverControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }
   //All tests must be written as test<SomeName>
   public function testMyFunction()
    {
       //user1 does have the permission
       $response = $this->actingAs($user1)->get(route('myFunction'));
       //the view response has code status 200 so we will check if the response is ok = 200
       $resp->assertOk();
       
       //user2 does not have the permission
       $response = $this->actingAs($user2)->get(route('myFunction'));
       //the redirect response is has status code 302 so we will check if the response is a redirect = 302
       $resp->assertRedirect();
    }
}
