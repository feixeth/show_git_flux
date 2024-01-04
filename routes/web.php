<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyCouplesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// render the activity on a html page
Route::get('/showactivity', function(){
    return view('showactivity');
})->name('showactivity');


// route to render git activity the first time + build rss html page link 
Route::get('/showactivity/{hubKey}/{labKey}', [KeyCouplesController::class, 'showActivity'])
    ->name('showactivity');


// route to store key in the DB 
Route::post('/create_couple', [KeyCouplesController::class, 'store']);

// display git activity based on the token - integer to third site
Route::get('/showgitfeed/{token}', [GitFeedController::class, 'showGitFeed']);
