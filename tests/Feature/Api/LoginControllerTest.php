<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function cannot_login_without_email(): void
    {
        $response = $this->postJson(route('api.login'));
        $response->assertJsonValidationErrorFor("email");
    }
    /**
     * @test
     */
    public function cannot_login_without_password(): void
    {
        $response = $this->postJson(route('api.login'),[
            'email' => 'example@example.com'
        ]);
        $response->assertJsonValidationErrorFor("password");
    }
    /**
     * @test
     */
    public function cannot_login_with_a_user_unexists(): void
    {
        $response = $this->postJson(route('api.login'),[
            'email' => 'example@example.com',
            'password' => 'password'
        ]);
        $response->assertJsonValidationErrorFor('email');
    }
    /**
     * @test
     */
    public function can_login_with_a_user_exists(): void
    {
        User::factory()->create([
            'email' => 'example@example.com'
        ]);
        $response = $this->postJson(route('api.login'),[
            'email' => 'example@example.com',
            'password' => 'password'
        ]);
        $response->assertSuccessful();
    }
}
