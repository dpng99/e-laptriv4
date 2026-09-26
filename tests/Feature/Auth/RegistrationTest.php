<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_is_disabled_by_default(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(404);

        $postResponse = $this->post('/register', [
            'username' => 'testuser',
            'nama_satker' => 'Test Satker',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $postResponse->assertStatus(404);
        $this->assertGuest();
    }

    public function test_registration_screen_can_be_rendered_when_enabled(): void
    {
        config(['auth.registration_enabled' => true]);

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_when_enabled(): void
    {
        config(['auth.registration_enabled' => true]);

        $response = $this->post('/register', [
            'username' => 'testuser',
            'nama_satker' => 'Test Satker',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
