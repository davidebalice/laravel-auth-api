<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\ResetRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetMail;
use Exception;

class ResetController extends Controller
{
    public function ResetPassword(ResetRequest $request){
		$email = $request->email;
    	$token = $request->token;
    	$password = Hash::make($request->password);

    	$emailcheck = DB::table('password_resets')->where('email',$email)->first();
    	$pincheck = DB::table('password_resets')->where('token',$token)->first();

    	if (!$emailcheck) {
    		return response([
    			'message' => "Email Not Found"
    		],401);    	 	 
    	 }
    	 if (!$pincheck) {
    		return response([
    			'message' => "Pin Code Invalid"
    		],401);    	 	 
    	 }

    	 DB::table('users')->where('email',$email)->update(['password' => $password]);
    	 DB::table('password_resets')->where('email',$email)->delete();

    	 return response([
    	 	'message' => 'Password Change Successfully'
    	 ],200);
    }
}
 
