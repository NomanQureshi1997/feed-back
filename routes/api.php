<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CommentController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/feedback', [FeedbackController::class, 'create']);
    Route::get('/feedbacks', [FeedbackController::class, 'index']);
    Route::post('/feedbacks/{feedbackId}/comments', [CommentController::class, 'store']);
    Route::get('/feedbacks/{feedbackId}/comments', [CommentController::class, 'index']);
});
