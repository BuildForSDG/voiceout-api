<?php

use Illuminate\Support\Facades\Route;
use App\Report;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/image', function () {
// 	// $hi = 'me';

// 	$report = Report::find(39);

//     return view('image', [ 'report' => $report ] );
// });


// Route::get('/users', function () {
//     return 'working';
// });


