<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
    public function new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'kana' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'postal_code' => '1234567',
            'address' => 'Test Address',
            'phone_number' => '00000000000',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);  // ここで'/'にリダイレクトすることを期待
    }
}
