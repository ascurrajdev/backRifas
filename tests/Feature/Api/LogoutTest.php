<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_logout_a_user_logged(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['*']);
        $response = $this->postJson(route('api.logout'));
        $this->assertDatabaseEmpty("personal_access_tokens");
        $response->assertSuccessful();
    }
}
