<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Elektronik',
                'description' => 'Produk elektronik dan gadget'
            ],
            [
                'name'        => 'Pakaian',
                'description' => 'Pakaian pria dan wanita'
            ],
            [
                'name'        => 'Makanan & Minuman',
                'description' => 'Produk makanan dan minuman'
            ],
            [
                'name'        => 'Olahraga',
                'description' => 'Peralatan dan pakaian olahraga'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}