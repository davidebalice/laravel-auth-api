<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;


class AuthController extends Controller
{
    public function Login(Request $request){

    	try{
    		if (Auth::attempt($request->only('email','password'))) {
    			$user = Auth::user();
    			$token = $user->createToken('app')->accessToken;
				// generate Randome Token 
				//$token = rand(10,100000);
				//dd($token);

    			return response([
    				'message' => "Successfully Login",
    				'token' => $token,
    				'user' => $user
    			],200); // States Code
    		}

    	}catch(Exception $exception){
    		return response([
    			'message' => $exception->getMessage()
    		],400);
    	}
    	return response([
    		'message' => 'Invalid Email Or Password' 
    	],401);

    }

	public function Register(RegisterRequest $request){

    	try{
    		$user = User::create([
    			'name' => $request->name,
    			'email' => $request->email,
    			'password' => Hash::make($request->password) 
    		]);
    		$token = $user->createToken('app')->accessToken;

    		return response([
    			'message' => "Registration Successfull",
    			'token' => $token,
    			'user' => $user
    		],200);

	    	}catch(Exception $exception){
	    		return response([
	    			'message' => $exception->getMessage()
	    		],400);
	    	}
    }
}
