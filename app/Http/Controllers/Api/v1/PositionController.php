<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function move(Request $request)
    {
        $foo = 'bar';
        
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);
    }
}
