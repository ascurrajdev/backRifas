<?php

namespace Tests\Feature\Api\Raffles;

use App\Models\User;
use App\Models\Raffle;
use App\Models\AdminRaffle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListRafflesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_raffles_with_permissions_and_managment_availables(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, [
            "*"
        ]);
        Raffle::factory()->count(10)->create();
        $raffle = Raffle::first();
        AdminRaffle::factory()->for($raffle)->for($user)->create();
        $response = $this->getJson(route("api.raffles.index"));
        $response->assertSuccessful();
        $response->assertJsonCount(1,"data");
    }
}
