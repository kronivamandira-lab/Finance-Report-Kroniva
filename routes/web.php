<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Transaction;

Route::get('/dashboard', function () {
    $userId = auth()->id();
    $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;
    
    // Monthly data for chart (Jan - Dec)
    $monthlyData = [];
    for ($month = 1; $month <= 12; $month++) {
        $monthlyData[] = [
            'month' => date('M', mktime(0, 0, 0, $month, 1)),
            'income' => Transaction::where('user_id', $userId)->where('type', 'income')
                ->whereYear('transaction_date', now()->year)
                ->whereMonth('transaction_date', $month)
                ->sum('amount'),
            'expense' => Transaction::where('user_id', $userId)->where('type', 'expense')
                ->whereYear('transaction_date', now()->year)
                ->whereMonth('transaction_date', $month)
                ->sum('amount')
        ];
    }
    
    // Category data for pie chart
    $categoryData = Transaction::with('category')
        ->where('user_id', $userId)
        ->where('type', 'expense')
        ->selectRaw('category_id, SUM(amount) as total')
        ->groupBy('category_id')
        ->get();
    
    // Recent transactions
    $recentTransactions = Transaction::with('category')
        ->where('user_id', $userId)
        ->orderBy('transaction_date', 'desc')
        ->limit(3)
        ->get();
    
    // Calculate percentage changes
    $currentMonth = now();
    $lastMonth = now()->subMonth();
    
    $currentMonthIncome = Transaction::where('user_id', $userId)->where('type', 'income')
        ->whereYear('transaction_date', $currentMonth->year)
        ->whereMonth('transaction_date', $currentMonth->month)
        ->sum('amount');
    $lastMonthIncome = Transaction::where('user_id', $userId)->where('type', 'income')
        ->whereYear('transaction_date', $lastMonth->year)
        ->whereMonth('transaction_date', $lastMonth->month)
        ->sum('amount');
    
    $currentMonthExpense = Transaction::where('user_id', $userId)->where('type', 'expense')
        ->whereYear('transaction_date', $currentMonth->year)
        ->whereMonth('transaction_date', $currentMonth->month)
        ->sum('amount');
    $lastMonthExpense = Transaction::where('user_id', $userId)->where('type', 'expense')
        ->whereYear('transaction_date', $lastMonth->year)
        ->whereMonth('transaction_date', $lastMonth->month)
        ->sum('amount');
    
    $incomeChange = $lastMonthIncome > 0 ? (($currentMonthIncome - $lastMonthIncome) / $lastMonthIncome) * 100 : 0;
    $expenseChange = $lastMonthExpense > 0 ? (($currentMonthExpense - $lastMonthExpense) / $lastMonthExpense) * 100 : 0;
    $balanceChange = ($lastMonthIncome + $lastMonthExpense) > 0 ? ((($currentMonthIncome - $currentMonthExpense) - ($lastMonthIncome - $lastMonthExpense)) / ($lastMonthIncome + $lastMonthExpense)) * 100 : 0;
    
    return view('dashboard', compact('totalIncome', 'totalExpense', 'balance', 'monthlyData', 'categoryData', 'recentTransactions', 'incomeChange', 'expenseChange', 'balanceChange'));
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LaporanController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/pemasukan', [TransactionController::class, 'income'])->name('pemasukan');
    Route::get('/pengeluaran', [TransactionController::class, 'expense'])->name('pengeluaran');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    
    Route::post('/kategori', [CategoryController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('kategori.destroy');
    
    Route::post('/transaksi', [TransactionController::class, 'store'])->name('transaksi.store');
    Route::put('/transaksi/{transaction}', [TransactionController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('transaksi.destroy');
});

require __DIR__.'/auth.php';
