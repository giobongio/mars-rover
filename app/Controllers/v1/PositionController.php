<?php

namespace App\Controllers\v1;

use App\Controllers\Controller;
use App\Data\PositionData;
use App\Enums\Direction;
use App\Repositories\PositionRepository;
use App\Repositories\ObstacleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PositionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function move(Request $request): Response
    {
        /*$body = [
            'name' => 'Abigail',
            'state' => 'CA',
            'zip' => 29121,
        ];

        $x = 20;
        $y = 30;
        $direction = Direction::WEST;

        $positionData = new PositionData(
            $x,
            $y,
            $direction
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($positionData);
        $foo = $positionRepository->get(1);*/

        /*$obstacleRepository = new ObstacleRepository();
        $foo = $obstacleRepository->getAll();*/

        $body = 'foo';
        return Response($body, Response::HTTP_OK);
    }
}
