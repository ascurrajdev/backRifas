<?php

namespace Tests\Feature\Api\AdminRaffles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Raffle;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ListRaffleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_administrators_raffles(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,["*"]);
        $raffle = Raffle::factory()->create();
        $response = $this->getJson(route("api.raffles.admin.index",$raffle));
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_list_all_administrators_raffles_without_not_has_permissions(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,["list"]);
        $raffle = Raffle::factory()->create();
        $response = $this->getJson(route("api.raffles.admin.index",$raffle));
        $response->assertForbidden();
    }
}
