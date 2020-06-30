<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



use App\User;
use App\Voice;
use App\Institution;

use Illuminate\Http\Request;

class AuthController extends Controller
{

	public function register(Request $request)
	{

		$validated = $request->validate([
			'email' => 'required|email',
			'password' => 'required',  
			'first_name' => 'string',
			'last_name' => 'string',
		]);

		$user = App\User::create([
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

		$user = App\User::firstWhere('email', $request->email);

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
}
