<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Symfony\Component\HttpFoundation\Response;

class test extends Controller
{
    public function index()
    {
        $film = Status::where('id', '1')->with('films')->Orderby('created_at','desc')->get();
        $response = [
            'message' => 'This response is List of Films (Now Playing)',
            'data' => $film
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
