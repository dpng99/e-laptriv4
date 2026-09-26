<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if ($user && ! $user->isActive()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            abort(Response::HTTP_FORBIDDEN, 'Akun Anda telah dinonaktifkan.');
        }

        $allowed = match ($role) {
            'admin' => $user?->isAdmin(),
            'operator' => $user?->isOperator(),
            default => false,
        };

        abort_unless($allowed, Response::HTTP_FORBIDDEN, 'Anda tidak memiliki akses ke menu ini.');

        return $next($request);
    }
}
