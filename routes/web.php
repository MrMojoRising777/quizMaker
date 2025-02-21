<?php

use App\Http\Controllers\HostedQuizController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoundController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['web']], function() {

    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::post('/profile-image', 'updateProfileImage')->name('updateProfileImage');
            Route::delete('/', 'destroy')->name('destroy');
        });

//        // Quizmaster routes
        Route::group(['middleware' => ['role:Quizmaster|Super Admin']], function () {
            Route::controller(QuizController::class)->prefix('quiz')->name('quiz.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/create', 'create')->name('create');
                Route::get('/view/{quiz}', 'show')->name('show');
                Route::post('/store/{quiz}', 'store')->name('store');
//                Route::post('/new-round/{quiz}', 'createRound')->name('createRound');
//
//                Route::delete('/delete/{quiz}', 'delete')->name('delete');
//
//                Route::get('play/{quiz}/waiting-room', 'openWaitingRoom')->name('hosted.waiting-room');
            });

            Route::controller(RoundController::class)->prefix('round')->name('rounds.')->group(function () {
                Route::post('/{round}/3-6-9/store', 'store')->name('store.369');
                Route::post('/{round}/open-deur/store', 'storeOpenDeur')->name('store.open-deur');
            });
        });
//
//        // Player routes
//        Route::group(['middleware' => ['role:Player|Super Admin']], function () {
//            // Reviews
//            Route::controller(ReviewController::class)->prefix('review')->name('reviews.')->group(function () {
//                Route::post('/store/{quiz}', 'store')->name('store');
//
//            });
//
//            Route::controller(HostedQuizController::class)->prefix('hosted-quiz')->name('hosted-quiz.')->group(function () {
//                Route::get('/{id}/waiting-room', 'showWaitingRoom')->name('waiting-room');
//            });
//        });
    });


    require __DIR__.'/auth.php';
});
