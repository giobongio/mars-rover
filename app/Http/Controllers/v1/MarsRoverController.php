<?php

namespace App\Http\Controllers\v1;

use App\ApplicationLogic\MarsRoverControlSystemInterface;
use App\Data\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendCommandsRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Response;

class MarsRoverController extends Controller
{
    use DataHelper;

    public function sendCommands(SendCommandsRequest $request): Response
    {
        $marsRoverControlSystem = App::make(MarsRoverControlSystemInterface::class);
        $result = $marsRoverControlSystem->sendCommands($request['commands']);
        
        return Response(DataHelper::toAssociativeArray($result), Response::HTTP_OK);
    }
}
