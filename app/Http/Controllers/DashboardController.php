<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Dashboard', [
            'routes' => [
                'home' => route('dashboard'),
                'quizIndex' => route('quizzes.index'),
            ]
        ]);
    }
}
