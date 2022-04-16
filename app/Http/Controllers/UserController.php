<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            $success = false;
            return response()->json(['success'=>$success, $validator->errors()]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;
        $success = true;

        return response()
            ->json(['success'=>$success, 'data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('name', 'password')))
        {
            $success = false;
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('name', $request['name'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
        $success = true;

        return response()
            ->json(['success'=>$success,'message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer','uid'=>$user->id ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'success' => true,
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
