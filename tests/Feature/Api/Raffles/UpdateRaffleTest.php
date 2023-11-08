<?php

namespace Tests\Feature\Api\Raffles;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateRaffleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_update_a_raffle_with_a_user_with_token_abilities(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $raffle = Raffle::factory()->create();
        $response = $this->putJson(route('api.raffles.update',$raffle),[
            'description' => 'Prueba'
        ]);
        $this->assertDatabaseHas('raffles',[
            'description' => 'Prueba'
        ]);
        $response->assertStatus(200);
    }
}
