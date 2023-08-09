<?php

namespace Tests\Feature\Api\AdminRaffles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Raffle;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class StoreRaffleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_store_a_admin_raffle_with_permissions(): void
    {
        $raffle = Raffle::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,[
            'create_admin_raffle'
        ]);
        $response = $this->postJson(route('api.raffles.admin.store',[$raffle]),[
            'user_id' => $user->id
        ]);
        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function cannot_store_a_admin_raffle_without_permissions(): void
    {
        $raffle = Raffle::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,[
            'create_admin_raffle_1'
        ]);
        $response = $this->postJson(route('api.raffles.admin.store',[$raffle]),[
            'user_id' => $user->id
        ]);
        $response->assertForbidden();
    }
}
