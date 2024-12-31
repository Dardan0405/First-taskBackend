<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\InstructorsAuthController;
use App\Http\Controllers\AdminsAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserControllerDetails;
use App\Http\Controllers\ThreadController;
Route::get('/', function () {
    // return view('welcome');
    return "First Program";
});

Route::post('/user-regist', [UserAuthController::class, 'register']);
Route::post('/user-login', [UserAuthController::class, 'login']);
Route::post('/admin-register', [AdminsAuthController::class, 'register']);
Route::post('/admin-login', [AdminsAuthController::class, 'login']);

Route::post('/instructor-register', [UserAuthController::class, 'register']);
Route::get('/users', [UserController::class, 'showAll']);
Route::get('/users-details', [UserControllerDetails::class, 'showAll']);
Route::post('/instructor-login', [InstructorsAuthController::class, 'login']);
Route::post('/courses/create', [CourseController::class, 'create']);
Route::post('/courses/enroll', [CourseController::class, 'enroll']);
Route::delete('/courses/delete', [CourseController::class, 'delete']);
Route::post('/threads/post', [ThreadController::class, 'postThread']);
Route::post('/threads/reply', [ThreadController::class, 'replyToThread']);
Route::delete('/replies/delete', [ThreadController::class, 'deleteReply']);
Route::delete('/replies/deleteuser', [ThreadController::class, 'deleteReply1']);








