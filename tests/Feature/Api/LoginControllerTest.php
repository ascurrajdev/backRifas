<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
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
}
