<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        $quizzes = Auth::user()->quiz;
        return Inertia::render('Dashboard', [
            'quizzes' => $quizzes,
        ]);
    }
}
