<?php

namespace App\Http\Controllers\v1;

use App\ApplicationLogic\MarsRover;
use App\Data\Position;
use App\Enums\Direction;
use App\ApplicationLogic\MarsRoverControlSystem;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendCommandsRequest;
use App\Repositories\ObstacleRepository;
use App\Repositories\PositionRepository;
use Illuminate\Http\Response;

class MarsRoverController extends Controller
{
    public function sendCommands(SendCommandsRequest $request): Response
    {
        $x = 10;
        $y = 20;
        $direction = Direction::NORTH;

        $marsRover = new MarsRover(
            config('app.planisphere.total_parallels'),
            config('app.planisphere.total_meridians'),
            new PositionRepository(),
            new ObstacleRepository()
        );

        $marsRover->setPosition(new Position($x, $y, $direction));
        $marsRoverControlSystem = new MarsRoverControlSystem($marsRover);

        $result = $marsRoverControlSystem->sendCommands($request['commands']);

        /*$body = [
            'name' => 'Abigail',
            'state' => 'CA',
            'zip' => 29121,
        ];

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
        $foo = $positionRepository->get(1);*/

        /*$obstacleRepository = new ObstacleRepository();
        $foo = $obstacleRepository->getAll();*/

        return Response($result, Response::HTTP_OK);
    }
}
