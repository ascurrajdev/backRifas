<?php

namespace Tests\Feature\Api\AdminRaffles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AdminRaffle;
use App\Models\Raffle;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ShowRaffleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_show_a_raffle_with_permissions(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['list_admin_raffle']);
        $raffle = Raffle::factory()->create();
        $adminRaffle = AdminRaffle::factory()
        ->for($raffle)
        ->for($user)
        ->create();
        $response = $this->getJson(route('api.raffles.admin.show',[$raffle,$adminRaffle]));
        $response->assertSuccessful();
    }
}
