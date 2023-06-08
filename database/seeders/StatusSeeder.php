<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'name' => "Pending",
            "is_pending" => true
        ]);
        Status::create([
            'name' => "Done",
            "is_done" => true
        ]);
        Status::create([
            'name' => "Cancelled",
            "is_cancelled" => true
        ]);
    }
}
