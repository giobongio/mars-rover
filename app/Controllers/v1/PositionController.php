<?php

namespace App\Controllers\v1;

use App\Controllers\Controller;
use App\Data\PositionData;
use App\Enums\RoverDirection;
use App\Repositories\PositionRepository;
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
        $body = [
            'name' => 'Abigail',
            'state' => 'CA',
            'zip' => 29121,
        ];

        $pointX = 20;
        $pointY = 30;
        $roverDirection = RoverDirection::WEST;

        $positionData = new PositionData(
            $pointX,
            $pointY,
            $roverDirection
        );

        $positionRepository = new PositionRepository();
        $positionRepository->save($positionData);
        $foo = $positionRepository->get(1);

        return Response($body, Response::HTTP_OK);
    }
}
