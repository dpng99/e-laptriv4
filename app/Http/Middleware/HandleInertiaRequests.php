<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'username' => $user->username,
                    'nama_satker' => $user->nama_satker,
                    'bidang_id' => $user->bidang_id,
                    'role_id' => $user->role_id,
                    'kinerja_role' => $user->kinerja_role,
                    'is_active' => (bool) $user->is_active,
                    'kinerja_is_active' => (bool) $user->kinerja_is_active,
                    'kinerja_unit_kerja_id' => $user->kinerja_unit_kerja_id,
                    'is_admin' => $user->isAdmin(),
                    'is_operator' => $user->isOperator(),
                    'landing_route' => $user->landingRoute(),
                ] : null,
            ],
        ];
    }
}
