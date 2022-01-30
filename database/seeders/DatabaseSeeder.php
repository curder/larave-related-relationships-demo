<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()
             ->count(10)
             ->for(User::factory()->create())
             ->create();
    }
}
