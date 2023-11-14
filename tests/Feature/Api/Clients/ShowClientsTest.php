<?php

namespace Tests\Feature\Api\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowClientsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_show_a_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        Sanctum::actingAs($user,[
            '*'
        ]);
        $response = $this->getJson(route('api.clients.show',$client));
        $response->assertStatus(200);
    }
}
