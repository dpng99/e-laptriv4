<?php

namespace App\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);

        // Rate limiter for report export (10 downloads per minute per user/IP)
        RateLimiter::for('export', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->username ?: $request->ip());
        });

        // Application logging: Authentication events
        Event::listen(Login::class, function (Login $event) {
            Log::info('Auth Event: User logged in', [
                'username' => $event->user->username ?? 'unknown',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        Event::listen(Failed::class, function (Failed $event) {
            Log::warning('Auth Event: Failed login attempt', [
                'username' => $event->credentials['username'] ?? null,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                Log::info('Auth Event: User logged out', [
                    'username' => $event->user->username ?? 'unknown',
                    'ip' => request()->ip(),
                ]);
            }
        });
    }
}
