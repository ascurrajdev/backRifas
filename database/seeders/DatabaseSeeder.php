<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Raffle;
use App\Models\UserRaffle;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "Jose Ascurra",
            "email" => "joseascurra123@gmail.com",
            "password" => Hash::make("password"),
        ]);
        $raffle = Raffle::create([
            'description' => "Todos por Kamila Lcik",
            'amount' => 10000
        ]);
        UserRaffle::create([
            'raffle_id' => $raffle->id,
            'user_id' => $user->id,
            'id' => Str::uuid()->toString(),
            'max_number' => 2,
            'min_number' => 1
        ]);
    }
}
