<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income Categories
            ['name' => 'Gaji', 'type' => 'income', 'icon' => 'fas fa-briefcase'],
            ['name' => 'Bonus', 'type' => 'income', 'icon' => 'fas fa-trophy'],
            ['name' => 'Investasi', 'type' => 'income', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Lainnya', 'type' => 'income', 'icon' => 'fas fa-coins'],
            
            // Expense Categories
            ['name' => 'Makanan', 'type' => 'expense', 'icon' => 'fas fa-utensils'],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => 'fas fa-car'],
            ['name' => 'Utilitas', 'type' => 'expense', 'icon' => 'fas fa-bolt'],
            ['name' => 'Hiburan', 'type' => 'expense', 'icon' => 'fas fa-gamepad'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => 'fas fa-heartbeat'],
            ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => 'fas fa-graduation-cap'],
            ['name' => 'Belanja', 'type' => 'expense', 'icon' => 'fas fa-shopping-bag'],
            ['name' => 'Lainnya', 'type' => 'expense', 'icon' => 'fas fa-ellipsis-h']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}