<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('admin/rooms/save/{room}', 'App\Http\Controllers\RoomController@save')->name('admin.rooms.save');
Route::post('user/{user}/rooms/save/{room}', 'App\Http\Controllers\ProgressController@saveStudentProgress')->name('user.rooms.save');
