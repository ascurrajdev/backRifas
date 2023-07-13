<?php

namespace Tests\Feature\Api\Raffles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreRaffleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_store_a_raffle_with_a_file(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $file = UploadedFile::fake()->image("test.png");
        $response = $this->postJson(route("api.raffles.store"),[
            'image' => $file,
            'description' => fake()->words(5, true),
            'amount' => 1000
        ]);
        $response->assertSuccessful();
    }
}
