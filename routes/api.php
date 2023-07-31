<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\TagsController;
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

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/verify',[AuthController::class, 'verify']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tags', [TagsController::class, 'index']);
    Route::post('/tags', [TagsController::class, 'store']);
    Route::put('/tags/{tag}', [TagsController::class, 'update']);
    Route::delete('/tags/{tag}', [TagsController::class, 'destroy']);


    Route::get('/posts', [PostsController::class, 'index']);
    Route::get('/posts/deleted', [PostsController::class, 'deletedPosts']);
    Route::post('/posts', [PostsController::class, 'store']);
    Route::get('/posts/{id}', [PostsController::class, 'show']);
    Route::put('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);
    Route::put('/posts/{id}/restore', [PostsController::class, 'restore']);
});