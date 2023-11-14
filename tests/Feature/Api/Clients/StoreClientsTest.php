<?php

namespace Tests\Feature\Api\Clients;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreClientsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_store_a_client(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['*']);
        $response = $this->postJson(route('api.clients.store',[
            'name' => 'Jose',
            'email' => 'joseascurra123@gmail.com',
            'cellphone' => '0986939038'
        ]));
        $response->assertCreated();
    }
}
