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
Route::post('/reports/{report_id}/upvote', 'ReportController@upvote');
Route::post('/reports/{report_id}/downvote', 'ReportController@downvote');
Route::post('/reports/{report_id}/comment', 'ReportController@comment');

Route::get('/users/{user_id}/reports', 'UserController@reports');
Route::get('/reports/hi', 'ReportController@hi');
Route::get('/reports/{report_id}/comments', 'ReportController@comments');
Route::get('/sectors/{sector_id}/reports', 'SectorController@reports');

Route::apiResource('/voices', 'VoiceController');
Route::apiResource('/comments', 'CommentController');
Route::apiResource('/reports', 'ReportController');
Route::apiResource('/users', 'UserController');
Route::apiResource('/sectors', 'SectorController');
