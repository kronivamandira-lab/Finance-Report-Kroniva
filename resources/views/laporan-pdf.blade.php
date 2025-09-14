<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan {{ $selectedYear }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #003e7f;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #003e7f;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .summary-item {
            text-align: center;
            flex: 1;
            padding: 15px;
            margin: 0 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .summary-item h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }
        .summary-item .amount {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .income { color: #28a745; }
        .expense { color: #dc3545; }
        .balance { color: #003e7f; }
        
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #003e7f;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #003e7f;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        
        .category-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan {{ $selectedYear }}</h1>
        <p>{{ Auth::user()->name }} - {{ now()->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <h3>Total Pemasukan</h3>
            <p class="amount income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h3>Total Pengeluaran</h3>
            <p class="amount expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h3>Saldo Bersih</h3>
            <p class="amount balance">Rp {{ number_format($balance, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="section">
        <h2>Kategori Pengeluaran Teratas</h2>
        @forelse($expenseByCategory->sortByDesc('total')->take(5) as $categoryData)
        @php
            $percentage = $totalExpense > 0 ? ($categoryData->total / $totalExpense) * 100 : 0;
        @endphp
        <div class="category-item">
            <span>{{ $categoryData->category->name }}</span>
            <span>
                <strong>Rp {{ number_format($categoryData->total, 0, ',', '.') }}</strong>
                ({{ number_format($percentage, 1) }}%)
            </span>
        </div>
        @empty
        <p>Tidak ada data pengeluaran</p>
        @endforelse
    </div>

    <div class="section">
        <h2>Riwayat Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions->take(20) as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td class="text-center">
                        <span style="color: {{ $transaction->type === 'income' ? '#28a745' : '#dc3545' }}">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="text-right" style="color: {{ $transaction->type === 'income' ? '#28a745' : '#dc3545' }}">
                        {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($transactions->count() > 20)
        <p style="font-style: italic; color: #666;">* Menampilkan 20 transaksi terbaru dari {{ $transactions->count() }} total transaksi</p>
        @endif
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem Pelaporan Keuangan</p>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>
</body>
</html>