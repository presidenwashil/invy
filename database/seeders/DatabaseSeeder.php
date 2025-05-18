<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Item;
use App\Models\User;

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

        // Seed Suppliers
        $suppliers = [
            [
                'code' => 'SUP001',
                'name' => 'PD Dongoran',
                'contact' => '+62 (48) 456-3137',
                'address' => 'Jalan Raya Setiabudhi No. 8, Banjar, SB 31897'
            ],
            [
                'code' => 'SUP002',
                'name' => 'UD Mandasari (Persero) Tbk',
                'contact' => '+62-800-027-8010',
                'address' => 'Jl. Sentot Alibasa No. 240, Dumai, KT 22891'
            ],
            [
                'code' => 'SUP003',
                'name' => 'PT Nasyidah',
                'contact' => '+62-0494-437-5051',
                'address' => 'Jl. Cikapayang No. 6, Pagaralam, JI 31146'
            ],
            [
                'code' => 'SUP004',
                'name' => 'Perum Purnawati Kuswoyo (Persero) Tbk',
                'contact' => '+62 (0632) 431-7209',
                'address' => 'Jl. Dipatiukur No. 8, Medan, NB 36691'
            ],
            [
                'code' => 'SUP005',
                'name' => 'Perum Riyanti',
                'contact' => '+62 (055) 648 3700',
                'address' => 'Jalan K.H. Wahid Hasyim No. 0, Singkawang, JT 80415'
            ],
        ];
        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Seed Items
        $items = [
            [
                'code' => 'ITM001',
                'name' => 'Printer Canon',
                'category_id' => 1,
                'unit_id' => 2,
                'price' => 1500000,
                'stock' => 0
            ],
            [
                'code' => 'ITM002',
                'name' => 'Kertas A4',
                'category_id' => 2,
                'unit_id' => 3,
                'price' => 50000,
                'stock' => 0
            ],
            [
                'code' => 'ITM003',
                'name' => 'Meja Kantor',
                'category_id' => 3,
                'unit_id' => 1,
                'price' => 750000,
                'stock' => 0
            ],
            [
                'code' => 'ITM004',
                'name' => 'Sabun Pel Lantai',
                'category_id' => 4,
                'unit_id' => 5,
                'price' => 30000,
                'stock' => 0
            ],
            [
                'code' => 'ITM005',
                'name' => 'Mouse Logitech',
                'category_id' => 1,
                'unit_id' => 2,
                'price' => 250000,
                'stock' => 0
            ],
        ];
        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
