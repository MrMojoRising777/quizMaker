<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::setRootView('layouts.app');

        Inertia::share([
            'auth' => function () {
                $user = auth()->user();
                return [
                    'user' => $user?->only('id', 'name', 'email'),
                    'permissions' => $user?->getAllPermissions()->pluck('name'),
                    'roles' => $user?->getRoleNames(),
                ];
            },
        ]);
    }
}
