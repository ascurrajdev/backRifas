<?php

namespace Tests\Feature\Api\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListClientsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_clients(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,[
            '*'
        ]);
        Client::factory()->count(10)->create();
        $response = $this->getJson(route('api.clients.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(10,'data');
    }
}
