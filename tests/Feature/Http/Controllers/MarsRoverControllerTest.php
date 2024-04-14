<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Data\CommandResult;
use App\Data\DataHelper;
use App\Data\Position;
use App\Enums\Command;
use App\Enums\Direction;
use Tests\TestCase;
use Illuminate\Http\Response;

class MarsRoverControllerTest extends TestCase
{
    use RefreshDatabase;
    use DataHelper;
 
    public function test_marsRoverSetPosition_getExpectedResponse()
    {
        $data = [
            'x' => 10,
            'y' => 2,
            'direction' => 'N'
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $response = $this->postJson(
            'api/v1/marsrover/setPosition',
            $data,
            $headers
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true
            ]);
    }
 
    public function test_marsRoverSendCommands_getExpectedResponse()
    {
        $position = [
            'x' => 10,
            'y' => 2,
            'direction' => 'N'
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $this->postJson(
            'api/v1/marsrover/setPosition',
            $position,
            $headers
        );


        $data = [
            'commands' => ['f']
        ];

        $response = $this->postJson(
            'api/v1/marsrover/sendCommands',
            $data,
            $headers
        );

        $expectedCommandResults = [];
        $expectedCommandResults[] = new CommandResult(
            Command::MOVE_FORWARD, 
            new Position(
                $position['x'], 
                $position['y'] - 1, 
                Direction::getEnum($position['direction'])
            ), 
            true
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(DataHelper::convertToAssociativeArray($expectedCommandResults));
   }
 
    public function test_marsRoverWrap_getExpectedResponse()
    {
        $position = [
            'x' => 10,
            'y' => 2,
            'direction' => 'N'
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $this->postJson(
            'api/v1/marsrover/setPosition',
            $position,
            $headers
        );


        $data = [
            'commands' => 'f'
        ];

        $response = $this->postJson(
            'api/v1/marsrover/wrap',
            $data,
            $headers
        );

        $response->assertStatus(Response::HTTP_OK);
   }
}
