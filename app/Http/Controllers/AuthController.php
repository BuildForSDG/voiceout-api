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
		$role = $request->role;
		if (!$role) {
			$error = ['error' => 'user role isn\'t specified'];
			return response($error, 422);
		}

		$validated = $request->validate([
			'email' => 'required|email',
			'password' => 'required',  
			'first_name' => 'string',
			'last_name' => 'string',
			'name' => 'string',
			'description' => 'string',
			'address' => 'string'
		]);

		if ($role == 'voice') {
			$voice = Voice::create([
				'name' => $validated['name'],
				'description' => $validated['description'],
				'address' => $validated['address']
			]);

			$voice->user()->create([
				'email' => $validated['email'],
				'password' => Hash::make($validated['password']),
				'role' => $role
			]);

			$user = $voice->user->load('voice');
			$response = [
				'user' => $user,
				'message' => 'voice created successfully'
			];
			return response($response, 201);
			

		} elseif ($role == 'institution') {	
			
			$id = $request->institution_id;

			if (!$id) {

				$response = [
					'message' => 'institution id is required'
				];
				return response($response, 404);			
			}

			$institution = Institution::find($id);

			if (!$institution) {
				$response = [
					'message' => 'institution not found'
				];
				return response($response, 404);					
			}

			$institution->user()->create([
				'email' => $validated['email'],
				'password' => Hash::make($validated['password']),
				'role' => $role
			]);	

			$user = $institution->user->load('institution');

			$response = [
				'user' => $user,
				'message' => 'institution created successfully'
			];
			return response($response, 201);
			

		} elseif ($role == 'user') {
			$user = User::create([
				'email' => $validated['email'],
				'password' => $validated['password'],
				'first_name' => $validated['first_name'],
				'last_name' => $validated['last_name']
			]);

			$user->password = Hash::make($request->password);
			$user->save();

			$response = [
				'user' => $user,
				'message' => 'user created successfully'
			];
			return response($response, 201);

		}	
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
}
