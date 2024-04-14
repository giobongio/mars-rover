<?php

namespace App\Http\Controllers\v1;

use App\ApplicationLogic\MarsRoverControlSystemInterface;
use App\Data\DataHelper;
use App\Enums\Direction;
use App\Data\Position;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendCommandsRequest;
use App\Http\Requests\SetPositionRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class MarsRoverController extends Controller
{
    use DataHelper;

    public function setPosition(SetPositionRequest $request): Response
    {
        $marsRoverControlSystem = App::make(MarsRoverControlSystemInterface::class);
        
        $marsRoverControlSystem->setPosition(
            new Position(
                $request['x'], 
                $request['y'], 
                Direction::getEnum($request['direction'])
            )
        );
        
        return Response(['success' => true], Response::HTTP_OK);
    }

    public function sendCommands(SendCommandsRequest $request): Response
    {
        $marsRoverControlSystem = App::make(MarsRoverControlSystemInterface::class);
        $result = $marsRoverControlSystem->sendCommands($request['commands']);
        
        return Response(DataHelper::convertToAssociativeArray($result), Response::HTTP_OK);
    }

    public function wrap(): Response
    {
        $marsRoverControlSystem = App::make(MarsRoverControlSystemInterface::class);
        $result = $marsRoverControlSystem->wrap();
        
        return Response(DataHelper::convertToAssociativeArray($result), Response::HTTP_OK);
    }
}
