<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = [
            ['code' => 'CAT001', 'name' => 'Elektronik'],
            ['code' => 'CAT002', 'name' => 'ATK'],
            ['code' => 'CAT003', 'name' => 'Furniture'],
            ['code' => 'CAT004', 'name' => 'Kebersihan'],
            ['code' => 'CAT005', 'name' => 'Lainnya'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }

        // Seed Units
        $units = [
            ['code' => 'U001', 'name' => 'Unit'],
            ['code' => 'U002', 'name' => 'Pcs'],
            ['code' => 'U003', 'name' => 'Box'],
            ['code' => 'U004', 'name' => 'Kg'],
            ['code' => 'U005', 'name' => 'Liter'],
        ];
        foreach ($units as $unit) {
            Unit::create($unit);
        }

        // Seed Items
        $items = [
            [
                'code' => 'ITM001',
                'name' => 'Printer Canon',
                'category_id' => 1,
                'unit_id' => 2,
                'price' => 1500000,
                'stock' => 0,
            ],
            [
                'code' => 'ITM002',
                'name' => 'Kertas A4',
                'category_id' => 2,
                'unit_id' => 3,
                'price' => 50000,
                'stock' => 0,
            ],
            [
                'code' => 'ITM003',
                'name' => 'Meja Kantor',
                'category_id' => 3,
                'unit_id' => 1,
                'price' => 750000,
                'stock' => 0,
            ],
            [
                'code' => 'ITM004',
                'name' => 'Sabun Pel Lantai',
                'category_id' => 4,
                'unit_id' => 5,
                'price' => 30000,
                'stock' => 0,
            ],
            [
                'code' => 'ITM005',
                'name' => 'Mouse Logitech',
                'category_id' => 1,
                'unit_id' => 2,
                'price' => 250000,
                'stock' => 0,
            ],
        ];
        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
