<?php

use App\Http\Controllers\HostedQuizController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

//Route::group(['middleware' => ['permission:publish articles']], function () { ... });

    Route::middleware('auth')->group(function () {
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/profile', 'edit')->name('edit');
            Route::patch('/profile', 'update')->name('update');
            Route::delete('/profile', 'destroy')->name('destroy');
        });

        // Quizmaster routes
        Route::group(['middleware' => ['role:Quizmaster|Super Admin']], function () {
            Route::controller(QuizController::class)->prefix('quiz')->name('quiz.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/view/{quiz}', 'show')->name('show');
                Route::post('/store/{quiz}', 'store')->name('store');
                Route::post('/new-round/{quiz}', 'createRound')->name('createRound');

                Route::delete('/delete/{quiz}', 'delete')->name('delete');

                Route::get('play/{quiz}/waiting-room', 'openWaitingRoom')->name('hosted.waiting-room');
            });
        });

        // Player routes
        Route::group(['middleware' => ['role:Player|Super Admin']], function () {
            // Reviews
            Route::controller(ReviewController::class)->prefix('review')->name('reviews.')->group(function () {
                Route::post('/store/{quiz}', 'store')->name('store');

            });

            Route::controller(HostedQuizController::class)->prefix('hosted-quiz')->name('hosted-quiz.')->group(function () {
                Route::get('/{id}/waiting-room', 'showWaitingRoom')->name('waiting-room');
            });
        });
    });


    require __DIR__.'/auth.php';
});
