<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ApplicationLoggingTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_login_event_is_logged(): void
    {
        Log::spy();

        $user = User::factory()->create([
            'username' => 'operator.log.test',
            'password' => 'secret123',
            'bidang_id' => 'SET',
            'role_id' => 'OPR',
            'is_active' => true,
        ]);

        $this->post('/login', [
            'username' => 'operator.log.test',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticated();

        Log::shouldHaveReceived('info')
            ->withArgs(function ($message, $context) {
                return str_contains($message, 'Auth Event: User logged in')
                    && ($context['username'] ?? null) === 'operator.log.test';
            });
    }

    public function test_failed_login_attempt_is_logged(): void
    {
        Log::spy();

        $this->post('/login', [
            'username' => 'wrong.user',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();

        Log::shouldHaveReceived('warning')
            ->withArgs(function ($message, $context) {
                return str_contains($message, 'Auth Event: Failed login attempt')
                    && ($context['username'] ?? null) === 'wrong.user';
            });
    }
}
