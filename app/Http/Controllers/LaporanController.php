<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $selectedYear = $request->get('year', now()->year);
        
        // Total stats for selected year
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $selectedYear)
            ->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $selectedYear)
            ->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        // Monthly stats for selected year
        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $selectedYear)
            ->whereMonth('transaction_date', now()->month)
            ->sum('amount');
        $monthlyExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $selectedYear)
            ->whereMonth('transaction_date', now()->month)
            ->sum('amount');
        
        // Average calculations for selected year
        $incomeCount = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $selectedYear)
            ->count();
        $expenseCount = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $selectedYear)
            ->count();
        $avgIncome = $incomeCount > 0 ? $totalIncome / $incomeCount : 0;
        $avgExpense = $expenseCount > 0 ? $totalExpense / $expenseCount : 0;
        
        // Recent transactions for selected year
        $recentTransactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->whereYear('transaction_date', $selectedYear)
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();
        
        // Category breakdown for selected year
        $expenseByCategory = Transaction::with('category')
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $selectedYear)
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->get();
        
        // Monthly trend data for chart (Jan - Dec) for selected year
        $monthlyTrendData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyTrendData[] = [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'income' => Transaction::where('user_id', $userId)->where('type', 'income')
                    ->whereYear('transaction_date', $selectedYear)
                    ->whereMonth('transaction_date', $month)
                    ->sum('amount'),
                'expense' => Transaction::where('user_id', $userId)->where('type', 'expense')
                    ->whereYear('transaction_date', $selectedYear)
                    ->whereMonth('transaction_date', $month)
                    ->sum('amount')
            ];
        }
        
        // Available years for dropdown
        $availableYears = Transaction::where('user_id', $userId)
            ->selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        // Calculate percentage changes from previous year
        $previousYear = $selectedYear - 1;
        $prevYearIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $previousYear)
            ->sum('amount');
        $prevYearExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $previousYear)
            ->sum('amount');
        
        $incomeChangeYear = $prevYearIncome > 0 ? (($totalIncome - $prevYearIncome) / $prevYearIncome) * 100 : 0;
        $expenseChangeYear = $prevYearExpense > 0 ? (($totalExpense - $prevYearExpense) / $prevYearExpense) * 100 : 0;
        $balanceChangeYear = ($prevYearIncome + $prevYearExpense) > 0 ? ((($totalIncome - $totalExpense) - ($prevYearIncome - $prevYearExpense)) / ($prevYearIncome + $prevYearExpense)) * 100 : 0;
        
        // Comparison data (last 3 months)
        $comparisonData = [];
        for ($i = 2; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $comparisonData[] = [
                'month' => $date->format('M'),
                'income' => Transaction::where('user_id', $userId)->where('type', 'income')
                    ->whereYear('transaction_date', $date->year)
                    ->whereMonth('transaction_date', $date->month)
                    ->sum('amount'),
                'expense' => Transaction::where('user_id', $userId)->where('type', 'expense')
                    ->whereYear('transaction_date', $date->year)
                    ->whereMonth('transaction_date', $date->month)
                    ->sum('amount')
            ];
        }
        
        return view('laporan', compact(
            'totalIncome', 'totalExpense', 'balance',
            'monthlyIncome', 'monthlyExpense',
            'avgIncome', 'avgExpense',
            'recentTransactions', 'expenseByCategory',
            'monthlyTrendData', 'comparisonData',
            'selectedYear', 'availableYears',
            'incomeChangeYear', 'expenseChangeYear', 'balanceChangeYear'
        ));
    }
}