<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    //
    public function register(RegistrationRequest $request)
    {
         $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);

        $token = auth()->login($user);
         //token
         return response()->json([
        'status' => 'success',
        'message'=>'User registered successfully',
        'data'=>[
            'user'=>$user,
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60
        ]
    ]);
    }
    public function Login(LoginRequest $request)
    {
         $credentials=$request->only('email','password');
        
        //if login was not successful
        if(!$token=auth()->attempt($credentials)){
            return response()->json([
            'status' => 'error',
            'message'=>'Credentials was invalid'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //if login successful
            return response()->json([
            'status' => 'success',
            'message'=>'User Log in successfully',
            'data'=>[
                'user'=>auth()->user(),  //get user from JWT token
                'access_token'=>$token,
                'token_type'=>'bearer',
                'expires_in'=>auth()->factory()->getTTL()*60
            ]
            ]);
    }
}
