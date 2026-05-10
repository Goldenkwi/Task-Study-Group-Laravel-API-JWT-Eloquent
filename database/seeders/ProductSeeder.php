<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'          => 'Laptop Gaming ASUS',
                'description'   => 'Laptop gaming high performance RTX 4060',
                'price'         => 15000000,
                'stock'         => 10,
                'internal_note' => 'Supplier A - gudang Jakarta',
                'category_id'   => 1
            ],
            [
                'name'          => 'iPhone 15 Pro',
                'description'   => 'Smartphone Apple terbaru',
                'price'         => 20000000,
                'stock'         => 5,
                'internal_note' => 'Supplier B - gudang Surabaya',
                'category_id'   => 1
            ],
            [
                'name'          => 'Samsung Galaxy S24',
                'description'   => 'Smartphone Samsung flagship',
                'price'         => 14000000,
                'stock'         => 8,
                'internal_note' => 'Supplier B - gudang Bandung',
                'category_id'   => 1
            ],
            [
                'name'          => 'Kaos Polos Cotton',
                'description'   => 'Kaos polos bahan cotton combed 30s',
                'price'         => 75000,
                'stock'         => 100,
                'internal_note' => 'Supplier C - konveksi Bandung',
                'category_id'   => 2
            ],
            [
                'name'          => 'Kemeja Flannel',
                'description'   => 'Kemeja flannel pria slim fit',
                'price'         => 150000,
                'stock'         => 50,
                'internal_note' => 'Supplier C - konveksi Solo',
                'category_id'   => 2
            ],
            [
                'name'          => 'Mie Instan Goreng',
                'description'   => 'Mie instan rasa goreng spesial',
                'price'         => 3500,
                'stock'         => 500,
                'internal_note' => 'Supplier D - distributor Indofood',
                'category_id'   => 3
            ],
            [
                'name'          => 'Sepatu Running Nike',
                'description'   => 'Sepatu lari Nike Air Max terbaru',
                'price'         => 1200000,
                'stock'         => 20,
                'internal_note' => 'Supplier E - distributor resmi Nike',
                'category_id'   => 4
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}