<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Supplier::factory(5)->create();
        \App\Models\Warehouse::factory(3)->create();
        \App\Models\Item::factory(20)->create();
        \App\Models\Transaction::factory(50)->create();
    }
}
