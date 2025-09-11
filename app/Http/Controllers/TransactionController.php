<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function income()
    {
        $transactions = Transaction::with('category')
            ->where('user_id', auth()->id())
            ->where('type', 'income')
            ->orderBy('transaction_date', 'desc')
            ->get();
        $categories = Category::where('type', 'income')->get();
        $totalIncome = $transactions->sum('amount');
        $monthlyIncome = $transactions->where('transaction_date', '>=', now()->startOfMonth())->sum('amount');
        $avgIncome = $transactions->count() > 0 ? $totalIncome / $transactions->count() : 0;
        return view('pemasukan', compact('transactions', 'categories', 'totalIncome', 'monthlyIncome', 'avgIncome'));
    }

    public function expense()
    {
        $transactions = Transaction::with('category')
            ->where('user_id', auth()->id())
            ->where('type', 'expense')
            ->orderBy('transaction_date', 'desc')
            ->get();
        $categories = Category::where('type', 'expense')->get();
        $totalExpense = $transactions->sum('amount');
        $monthlyExpense = $transactions->where('transaction_date', '>=', now()->startOfMonth())->sum('amount');
        $avgExpense = $transactions->count() > 0 ? $totalExpense / $transactions->count() : 0;
        return view('pengeluaran', compact('transactions', 'categories', 'totalExpense', 'monthlyExpense', 'avgExpense'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date'
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'type' => $request->type,
            'description' => $request->description,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date
        ]);

        $route = $request->type === 'income' ? 'pemasukan' : 'pengeluaran';
        return redirect()->route($route)->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date'
        ]);

        $transaction->update($request->only(['category_id', 'description', 'amount', 'transaction_date']));
        
        $route = $transaction->type === 'income' ? 'pemasukan' : 'pengeluaran';
        return redirect()->route($route)->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        $type = $transaction->type;
        $transaction->delete();
        
        $route = $type === 'income' ? 'pemasukan' : 'pengeluaran';
        return redirect()->route($route)->with('success', 'Transaksi berhasil dihapus');
    }
}