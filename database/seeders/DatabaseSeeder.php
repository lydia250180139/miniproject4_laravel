<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default user (sesuai README & PPT)
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'email' => 'admin@galerilaptop.test',
                'password' => Hash::make('admin123'),
            ]
        );

        // Staff demo user
        User::updateOrCreate(
            ['username' => 'staff'],
            [
                'name' => 'Staff Inventory',
                'role' => 'staff',
                'email' => 'staff@galerilaptop.test',
                'password' => Hash::make('staff123'),
            ]
        );

        // Kategori utama
        $laptop = Category::firstOrCreate(['name' => 'Laptop'], ['description' => 'Laptop kerja, gaming, dan kuliah']);
        $ipad = Category::firstOrCreate(['name' => 'iPad'], ['description' => 'Tablet iPad dan pendukungnya']);
        $aksesoris = Category::firstOrCreate(['name' => 'Aksesoris'], ['description' => 'Aksesoris laptop dan gadget']);

        // Supplier contoh
        Supplier::firstOrCreate(
            ['name' => 'Sumber Teknologi'],
            [
                'phone' => '081234567890',
                'email' => 'supplier@example.test',
                'address' => 'Lhokseumawe',
            ]
        );
        Supplier::firstOrCreate(
            ['name' => 'Mega Komputer Indo'],
            [
                'phone' => '082198765432',
                'email' => 'megakomputer@example.test',
                'address' => 'Banda Aceh',
            ]
        );

        // Produk contoh katalog Galeri Laptop
        $products = [
            [$laptop, 'LPT-001', 'ASUS VivoBook 14', 7800000, 8, 2],
            [$laptop, 'LPT-002', 'Lenovo IdeaPad Slim 3', 6900000, 3, 3],
            [$laptop, 'LPT-003', 'MacBook Air M2 256GB', 15999000, 5, 2],
            [$ipad, 'IPD-001', 'iPad 10th Generation 64GB', 6500000, 5, 2],
            [$ipad, 'IPD-002', 'iPad Air M2 11 Inch', 10499000, 4, 2],
            [$aksesoris, 'AKS-001', 'Mouse Wireless Logitech B170', 150000, 12, 4],
            [$aksesoris, 'AKS-002', 'Laptop Sleeve Case 14 Inch', 95000, 2, 3],
            [$aksesoris, 'AKS-003', 'USB-C Hub Multiport 7-in-1', 285000, 7, 3],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(
                ['sku' => $p[1]],
                [
                    'category_id' => $p[0]->id,
                    'name' => $p[2],
                    'price' => $p[3],
                    'stock' => $p[4],
                    'minimum_stock' => $p[5],
                    'description' => 'Data produk katalog resmi Galeri Laptop.',
                ]
            );
        }
    }
}
