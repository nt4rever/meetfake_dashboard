<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
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
});