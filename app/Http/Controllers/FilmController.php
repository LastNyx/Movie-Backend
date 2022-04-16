<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = Film::with('statuses')->with('user_film')->Orderby('created_at','desc')->get();
        $response = [
            'message' => 'This response is List of Films',
            'data' => $film
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->films,[
            'title' => ['required'],
            'status_id' => ['integer','min:1','max:2'],
        ],
            ['status_id.integer' => 'Please Select Movie Status']
        );

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $newFilm = new Film;
            $newFilm->title = $request->films["title"];
            $newFilm->thumbnail = $request->films["thumbnail"];
            $newFilm->status_id = $request->films['status_id'];
            $newFilm->save();

            $response = [
                'message' => 'Movie Created',
                'data' => $newFilm
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'message' => 'Failed',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::with('statuses')->findOrFail($id);
        return response()->json($film,Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'films.title' => ['required'],
            'films.status_id' => ['integer','min:1','max:2'],
        ],
            [
                'status_id.integer' => 'Please Select Movie Status'
            ]
        );

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            if($film){
                $film->title = $request->films['title'];
                $film->thumbnail = $request->films['thumbnail'];
                $film->status_id = $request->films['status_id'];
                $film->save();
            }
            $response = [
                'message' => 'Post Updated',
                'data' => $film
            ];

            return response()->json($response, Response::HTTP_OK);
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'message' => 'Failed',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::findOrFail($id);

        try{
            $film->delete();
            $response = [
                'message' => 'Post Deleted',
            ];

            return response()->json($response, Response::HTTP_OK);

        }catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'message' => 'Failed',
            ]);
        }
    }

}
