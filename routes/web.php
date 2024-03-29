<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'view']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::prefix('room')->group(function () {
    Route::get('/', [RoomController::class, 'list']);
    Route::get('/new', [RoomController::class, 'new']);
    Route::post('/save', [RoomController::class, 'save']);
    Route::get('/show/{id}', [RoomController::class, 'show']);
    Route::post('/update/{id}', [RoomController::class, 'update']);
    Route::post('/add/{id}', [RoomController::class, 'add']);
    Route::post('/delete_attendance/{id}', [RoomController::class, 'delete_attendance']);
    Route::get('/destroy/{id}', [RoomController::class, 'destroy']);
    Route::get('/log/{id}', [TrackingController::class, 'log']);
});

Route::get('/calendar', [HomeController::class, 'calendar']);

Route::prefix('api')->group(function () {
    Route::get('event', [EventController::class, 'getEvent']);
    Route::get('room-event', [EventController::class, 'getRoomEvent']);
    Route::post('save-event', [EventController::class, 'saveEvent']);
    Route::get('login', [AuthController::class, 'login_api']);
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'show']);
    Route::post('/save', [UserController::class, 'update']);
});

Route::get('/r/{room}', [HomeController::class, 'redirect']);
