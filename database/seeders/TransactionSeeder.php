<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $incomeCategories = Category::where('type', 'income')->get();
        $expenseCategories = Category::where('type', 'expense')->get();

        $transactions = [
            // Income transactions
            ['category_id' => $incomeCategories->where('name', 'Gaji')->first()->id, 'type' => 'income', 'description' => 'Gaji Bulanan', 'amount' => 8500000, 'transaction_date' => '2024-01-15'],
            ['category_id' => $incomeCategories->where('name', 'Bonus')->first()->id, 'type' => 'income', 'description' => 'Bonus Kinerja', 'amount' => 2500000, 'transaction_date' => '2024-01-10'],
            ['category_id' => $incomeCategories->where('name', 'Gaji')->first()->id, 'type' => 'income', 'description' => 'Gaji Desember', 'amount' => 8500000, 'transaction_date' => '2023-12-15'],
            
            // Expense transactions
            ['category_id' => $expenseCategories->where('name', 'Makanan')->first()->id, 'type' => 'expense', 'description' => 'Belanja Bulanan', 'amount' => 2750000, 'transaction_date' => '2024-01-14'],
            ['category_id' => $expenseCategories->where('name', 'Utilitas')->first()->id, 'type' => 'expense', 'description' => 'Listrik & Air', 'amount' => 850000, 'transaction_date' => '2024-01-12'],
            ['category_id' => $expenseCategories->where('name', 'Transportasi')->first()->id, 'type' => 'expense', 'description' => 'Bensin Motor', 'amount' => 150000, 'transaction_date' => '2024-01-10'],
            ['category_id' => $expenseCategories->where('name', 'Hiburan')->first()->id, 'type' => 'expense', 'description' => 'Nonton Bioskop', 'amount' => 100000, 'transaction_date' => '2024-01-08'],
            ['category_id' => $expenseCategories->where('name', 'Makanan')->first()->id, 'type' => 'expense', 'description' => 'Makan di Restoran', 'amount' => 250000, 'transaction_date' => '2024-01-05'],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create([
                'user_id' => $user->id,
                'category_id' => $transaction['category_id'],
                'type' => $transaction['type'],
                'description' => $transaction['description'],
                'amount' => $transaction['amount'],
                'transaction_date' => $transaction['transaction_date']
            ]);
        }
    }
}