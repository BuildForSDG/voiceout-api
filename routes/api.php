<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/users/{user_id}/reports', 'UserController@reports');
Route::apiResource('/users', 'UserController');
Route::apiResource('/reports', 'ReportController');

Route::get('/institutions/{institution_id}/reports', 'InstitutionController@reports');
Route::get('/institutions/{institution_id}/followers', 'InstitutionController@followers');
Route::apiResource('/institutions', 'InstitutionController');

Route::apiResource('/voices', 'VoiceController');
Route::apiResource('/comments', 'CommentController');

