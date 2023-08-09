<?php

namespace Tests\Feature\Api\AdminRaffles;

use App\Models\AdminRaffle;
use App\Models\Raffle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteAdminRaffleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_delete_a_admin_raffle_with_permissions(): void
    {
        $raffle = Raffle::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user, [
            'delete_admin_raffle'
        ]);
        AdminRaffle::factory()->for($raffle)->for($user)->create();
        $adminRaffle = AdminRaffle::factory()->for($raffle)->create();
        $response = $this->deleteJson(route('api.raffles.admin.delete',[$raffle, $adminRaffle]));
        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function cannot_delete_a_admin_raffle_without_permissions(): void
    {
        $raffle = Raffle::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user, [
            'delete_admin_raffle'
        ]);
        $adminRaffle = AdminRaffle::factory()->for($raffle)->create();
        $response = $this->deleteJson(route('api.raffles.admin.delete',[$raffle, $adminRaffle]));
        $response->assertForbidden();
    }
}
