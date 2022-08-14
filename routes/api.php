<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Authentication
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('logout', [AuthenticationController::class, 'logout']);

// User
Route::get('account', [UserController::class, 'account']);
Route::put('account', [UserController::class, 'update']);

// Posts
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);

// Categories
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/c/{name}', [CategoryController::class, 'show']);

// Bookmarks
Route::post('/bookmark/{id}', [BookmarkController::class, 'store']);
Route::delete('/bookmark/{id}', [BookmarkController::class, 'destroy']);
