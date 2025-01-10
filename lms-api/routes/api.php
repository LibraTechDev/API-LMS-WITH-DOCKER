<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\EnsureUserIsTeacher;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\api\CourseCommentController;
use App\Http\Controllers\api\CourseContentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->middleware(EnsureUserIsTeacher::class);
    Route::post('/user', [UserController::class, 'store'])->middleware(EnsureUserIsTeacher::class);
    Route::get('/user/{id}', [UserController::class, 'show'])->middleware(EnsureUserIsTeacher::class);
    Route::put('/user/{id}', [UserController::class, 'update'])->middleware(EnsureUserIsTeacher::class);
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware(EnsureUserIsTeacher::class);

    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store'])->middleware(EnsureUserIsTeacher::class);
    Route::get('/mycourses', [CourseController::class, 'myCourses']);
    Route::put('/courses/{course_id}', [CourseController::class, 'update'])->middleware(EnsureUserIsTeacher::class);
    Route::get('/courses/{course_id}', [CourseController::class, 'show']);
    Route::post('/courses/{course_id}/enroll', [CourseController::class, 'enroll']);
    Route::get('/courses/{id}/analytics', [CourseController::class, 'getAnalytics']);

    Route::get('/courses/{course_id}/contents', [CourseContentController::class, 'index']);
    Route::get('/courses/{course_id}/contents/{content_id}', [CourseContentController::class, 'show']);

    Route::get('/contents/{content_id}/comments', [CourseCommentController::class, 'index']);
    Route::post('/contents/{content_id}/comments', [CourseCommentController::class, 'store']);
    Route::delete('/comments/{comment_id}', [CourseCommentController::class, 'destroy']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store'])->middleware(EnsureUserIsTeacher::class);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware(EnsureUserIsTeacher::class);

    Route::post('courses/{courseId}/feedback', [FeedbackController::class, 'store']);
    Route::get('courses/{courseId}/feedback', [FeedbackController::class, 'index']);
    Route::put('feedback/{feedbackId}', [FeedbackController::class, 'update']);
    Route::delete('feedback/{feedbackId}', [FeedbackController::class, 'destroy']);

    Route::post('courses/{courseId}/announcement', [AnnouncementController::class, 'store'])->middleware(EnsureUserIsTeacher::class);
    Route::get('courses/{courseId}/announcement', [AnnouncementController::class, 'index']);
    Route::put('announcement/{announcementId}', [AnnouncementController::class, 'update'])->middleware(EnsureUserIsTeacher::class);
    Route::delete('announcement/{announcementId}', [AnnouncementController::class, 'destroy'])->middleware(EnsureUserIsTeacher::class);
});