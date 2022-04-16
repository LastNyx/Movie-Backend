<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
{
    public function index()
    {
        $film = Status::with('films')->Orderby('created_at','desc')->get();

        $response = [
            'message' => 'This response is List of Films (Sorted by status)',
            'data' => $film
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        $film = Status::where('id', $id)->with('films')->Orderby('created_at','desc')->get();

        if($id == 1){
            $message = 'This response is List of Films (Now Playing)';
        }else{
            $message = 'This response is List of Films (Coming Soon)';
        }

        $response = [
            'message' => $message,
            'data' => $film
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
