<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InertiaSharedPropsTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_user_props_are_whitelisted_and_do_not_leak_sensitive_fields(): void
    {
        $user = User::factory()->create([
            'username' => 'test.whitelisted',
            'nama_satker' => 'Satker Test Whitelist',
            'bidang_id' => 'SET',
            'role_id' => 'ADMIN',
            'password' => 'secret-hashed-password',
            'remember_token' => 'secret-remember-token',
        ]);

        $response = $this->actingAs($user)->get('/review-data');

        $response->assertInertia(fn (Assert $page) => $page
            ->has('auth.user', fn (Assert $userProps) => $userProps
                ->where('username', 'test.whitelisted')
                ->where('nama_satker', 'Satker Test Whitelist')
                ->where('bidang_id', 'SET')
                ->where('role_id', 'ADMIN')
                ->where('is_admin', true)
                ->where('is_operator', false)
                ->has('is_active')
                ->has('kinerja_is_active')
                ->has('kinerja_role')
                ->has('kinerja_unit_kerja_id')
                ->has('landing_route')
                ->missing('password')
                ->missing('remember_token')
                ->etc()
            )
        );
    }
}
