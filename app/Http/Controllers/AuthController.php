<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;


use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

	public function register(Request $request)
	{
		$role = $request->role;
		if (!$role) {
			$error = ['error' => 'user role isn\'t specified'];
			return response($error, 422);
		}

		if ($role == 'user') {
			$validated = $request->validate([
				'email' => 'required|email',
				'password' => 'required',  
				'first_name' => 'required|string',
				'last_name' => 'required|string',
			]);

		} else {
			$validated = $request->validate([
				'email' => 'required|email',
				'password' => 'required',  
				'name' => 'required|string',
				'description' => 'required|string',
				'address' => 'required|string'
			]);
		}


		$user = User::create($validated);
		$user->password = Hash::make($request->password);
		$user->role = $role;
		$user->save();

		$response = [
			'user' => $user,
			'message' => 'user created successfully'
		];
		return response($response, 201);

	}

	public function login(Request $request) {

		$request->validate([
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
		$user = User::find(8);
		$user->tokens()->whereName('user-token')->delete();

		$response = [
			'user' => $user,
			'message' => 'Log out successful'
		];

		return response($response, 200);
	}
}
