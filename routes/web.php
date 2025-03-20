<?php

use App\Events\AnswerRevealed;
use App\Http\Controllers\HostedQuizController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoundController;
use http\Client\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['web']], function() {

    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/drop', function () {
        \App\Models\Question::truncate();
        \App\Models\Answer::truncate();
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

//         Quizmaster routes
        Route::group(['middleware' => ['role:Quizmaster|Super Admin']], function () {
            Route::controller(QuizController::class)->prefix('quizzes')->name('quizzes.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/create', 'create')->name('create');
                Route::get('/view/{quiz}', 'show')->name('show');
                Route::post('/store/{quiz}', 'store')->name('store');

                Route::get('/{quiz}/preview-host', 'previewHost')->name('preview-host');
                Route::get('/{quiz}/preview-player', 'previewPlayer')->name('preview-player');

                Route::delete('/delete/{quiz}', 'delete')->name('delete');

                //** Events */
                Route::group(['as' => 'events.', 'prefix' => '/event'], function () {
                    Route::post('/reveal-answer/{question}', 'revealAnswer')->name('reveal-answer');
                    Route::post('/new-question/{question}/', 'newQuestion')->name('new-question');
                });
            });

            Route::controller(RoundController::class)->prefix('round')->name('rounds.')->group(function () {
                Route::post('/{round}/3-6-9/store', 'store')->name('store.369');
                Route::post('/{round}/open-deur/store', 'storeOpenDeur')->name('store.open-deur');
                Route::post('/{round}/puzzel/store', 'storePuzzel')->name('store.puzzel');
                Route::post('/{round}/ingelijst/store', 'storeIngelijst')->name('store.ingelijst');
                Route::post('/{round}/finale/store', 'storeFinale')->name('store.finale');
            });
        });

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
