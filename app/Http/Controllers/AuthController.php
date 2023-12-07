<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        //

        try {
            if (!Auth::attempt($credentials)) {

                return response(['message' => "Account is not registered"], 200);
            }

            // $user = $user->createTokento(Auth::user());
            $user = $this->model->where('email', $request->email)->first();


            // $token = $user->createToken($request->email . Str::random(8))->plainTextToken;
            // return response(['token' => $token, 'user' => $user], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage(), 'status' => false], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        //
        $request->validate([

            'name' => 'required|string',

            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8'
        ]);
        if (!$this->model->create($request->all())->exist)
            return response(['message' => 'data not inserted'], 200);
        try {
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage(), 'status' => false], 500);
        }


        /**
         * Display the specified resource.
         */
    }
}
