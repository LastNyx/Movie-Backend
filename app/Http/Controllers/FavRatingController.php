<?php

namespace App\Http\Controllers;

use App\Models\FavRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class FavRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FavRating::with('films')->with('users')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->favrating,[
            'film_id' => ['required',
                Rule::exists('films','id',"=",request()->favrating['film_id']),
            ],
            'user_id' => ['required',
                Rule::exists('users','id',"=",request()->favrating['user_id']),
            ],
            'favorite'=>['integer','min:0','max:1'],
            'rating'=>['integer','min:0','max:5']
        ],
            [
                'film_id.exists' => 'Film not Exists',
                'user_id.exists' => 'User not Exists',
                'favorite.min' => 'Favorite Value out of Range',
                'favorite.max' => 'Favorite Value out of Range',
                'rating.min' => 'Favorite Value out of Range',
                'rating.max' => 'Favorite Value out of Range',
            ],
        );

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $newfavrating = new FavRating;
            $newfavrating->film_id = $request->favrating['film_id'];
            $newfavrating->user_id = $request->favrating['user_id'];
            if(!empty($request->favrating['favorite'])){
                $newfavrating->favorite = $request->favrating['favorite'];
            }
            if(!empty($request->favrating['rating'])){
                $newfavrating->rating = $request->favrating['rating'];
            }
            $newfavrating->save();

            $response = [
                'message' => 'FavRating Created',
                'data' => $newfavrating
            ];

            return response()->json($response, Response::HTTP_CREATED);

        }catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'message' => 'This FavRating already Created',
                'response' => 422
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
        $film = FavRating::where('user_id',"=",$id)->with('films')->get();
        return response()->json($film,Response::HTTP_OK);
    }

    public function showFav($id)
    {
        $film = FavRating::where('user_id',"=",$id)->where('favorite',"=",1)->with('films')->get();
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
        $favrating = FavRating::findOrFail($id);

        $validator = Validator::make($request->favrating,[
            'favorite'=>['integer','min:0','max:1'],
            'rating'=>['integer','min:0','max:5']
        ],
            [
                'favorite.min' => 'Favorite Value out of Range',
                'favorite.max' => 'Favorite Value out of Range',
                'rating.min' => 'Favorite Value out of Range',
                'rating.max' => 'Favorite Value out of Range',
            ],
        );

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            if($favrating){

                    $favrating->favorite = $request->favrating['favorite'];

                if(!empty($request->favrating['rating'])){
                    $favrating->rating = $request->favrating['rating'];
                }
                $favrating->save();

                $response = [
                    'message' => 'FavRating Updated',
                    'data' => $favrating
                ];

                return response()->json($response, Response::HTTP_CREATED);
            }


        }catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'message' => 'This FavRating already Created',
                'response' => 422
            ]);
        }
    }
}
