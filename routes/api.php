<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\YouTubeLinkController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NewslettersubscriberController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::apiResource('posts', PostController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/newsletters/subscribe', [NewslettersubscriberController::class, 'subscribe']);


Route::controller(AdminController::class)->group(function () {
    Route::post('/login', 'login')->middleware('guest')->name('login');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/admin/blogs', 'blogStore');
        Route::post('/admin/youtube-links', 'youTubeStore');
        Route::get('/admin/newsletters', 'getAllSubscribers');
        Route::get('/admin/newsletters/{id}', 'getSubscriber')->where('id', '[0-9]+');
        Route::delete('/admin/newsletters/{id}', 'deleteSubscriber')->where('id', '[0-9]+');
    });
});


Route::controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'index');
    Route::get('/blog/{id}', 'show')->where('id', '[0-9]+');
    Route::get('/blogs/{slug}', 'showBySlug');


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/admin/blog', 'store');
        Route::put('/admin/blogs/{id}', 'update');
        Route::delete('/admin/blogs/{id}', 'destroy');
    });
});


Route::controller(YouTubeLinkController::class)->group(function () {
    Route::get('/youtube_links', 'index');
    Route::get('/youtube_link/{id}', 'show')->where('id', '[0-9]+');
    Route::get('/youtube_links/{slug}', 'showBySlug');

    Route::post('/admin/youtube_link', 'store');
    Route::put('/admin/youtube_link/{id}', 'update');
    Route::delete('/admin/youtube_link/{id}', 'destroy');
});


// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//     ->middleware('auth')
//     ->name('logout');
