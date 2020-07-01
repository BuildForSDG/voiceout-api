<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Voice;
use App\Institution;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class AuthController extends Controller
{

	// use VerifiesEmails;
 	// public $successStatus = 201;

	public function register(Request $request)
	{

		$validated = $request->validate([
			'email' => 'required|email',
			'password' => 'required',  
			'first_name' => 'string',
			'last_name' => 'string',
		]);

		$user = User::create([
			'email' => $validated['email'],
			'password' => $validated['password'],
			'first_name' => $validated['first_name'],
			'last_name' => $validated['last_name']
		]);

		$user->password = Hash::make($validated['password']);
		$user->save();

		$response = [
			'user' => $user,
			'message' => 'user created successfully'
		];
		return response($response, 201);	
	}

	public function login(Request $request) {

		$validated = $request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);

		$user = User::firstWhere('email', $request->email);

		if (!$user || !Hash::check($request->password, $user->password)) {
			return response([
				'message' => ['These credentials do not match our records.']
			], 404);
		}


		$token = $user->createToken('user-token')->plainTextToken;
		$response = [
			'user' => $user,
			'token' => $token
		];

		return response($response, 200);

	}


	public function logout(Request $request) {
		$user = auth('sanctum')->user();
		$user->tokens()->whereName('user-token')->delete();

		$response = [
			'user' => $user,
			'message' => 'Log out successful'
		];
		return response($response, 200);
	}


    // /**
    // * details api
    // *
    // * @return \Illuminate\Http\Response
    // */
    // public function details()
    // {
    //     $user = Auth::user();
    //     return Redirect::to('https://voiceout.netlify.app');
    //     // return response()->json(['success' => $user], $this->successStatus);
    // }


	// public function login(){
 //        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
 //            $user = Auth::user();
 //            if($user->email_verified_at !== NULL){

 //                // $success['message'] = 'Login successfull';
 //                // return response()->json(['success' => $success], $this->successStatus);

 //                $token = $user->createToken('user-token')->plainTextToken;
 //                $response = [
 //                    'user' => $user,
 //                    'token' => $token
 //                ];
 //                return response($response, 200);
 //            }else{
 //                return response()->json(['message'=>'Please Verify Email'], 404);
 //            }
 //        }
 //        else{
 //            return response()->json(['message'=>'These credentials do not match our records.'], 404);
 //        }
 //    }

    /**
    * Register api
    *
    // * @return \Illuminate\Http\Response
    */

 //    public function register(Request $request)
 //    {
 //        $validator = Validator::make($request->all(), [
 //            'email' => 'required|email',
 //            'password' => 'required',
 //            'first_name' => 'required|string',
 //            'last_name' => 'required|string'
 //        ]);

 //        if ($validator->fails()) {
 //            return response()->json(['error'=>$validator->errors()], 404);
 //        }

 //        $input = $request->all();
 //        $input['password'] = Hash::make($input['password']);
 //        $user = User::create($input);
 //        $user->sendApiEmailVerificationNotification();
 //        $success['message'] = 'Please confirm your account by clicking on verify user button sent to your mail: ' . $input['email'];
 //        return response()->json(['success'=>$success], 201);
 //    }




}
