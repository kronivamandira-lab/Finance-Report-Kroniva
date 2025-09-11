<x-layouts.app title="Dashboard">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        @media (min-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .chart-container {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .chart-container {
                padding: 1.5rem;
            }
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        @media (min-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        @media (min-width: 640px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1024px) {
            .quick-actions {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .action-btn {
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-align: left;
        }
        
        @media (max-width: 360px) {
            .stats-grid {
                gap: 0.5rem;
                margin-bottom: 1rem;
            }
            
            .stats-grid > div {
                padding: 0.75rem !important;
            }
            
            .stats-grid > div > div {
                flex-direction: column !important;
                text-align: center !important;
                gap: 0.5rem !important;
            }
            
            .stats-grid h3 {
                font-size: 0.7rem !important;
            }
            
            .stats-grid p {
                font-size: 1.1rem !important;
            }
            
            .stats-grid span {
                font-size: 0.6rem !important;
            }
            
            .stats-grid .icon-circle {
                width: 35px !important;
                height: 35px !important;
                font-size: 1rem !important;
            }
            
            .chart-container {
                padding: 0.5rem !important;
                margin-bottom: 0.75rem !important;
            }
            
            .chart-container h3 {
                font-size: 0.9rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .action-btn {
                padding: 0.5rem 0.25rem;
                gap: 0.25rem;
                font-size: 0.75rem;
            }
            
            .action-btn i {
                font-size: 1rem !important;
            }
            
            .action-btn div div:first-child {
                font-size: 0.75rem;
            }
            
            .action-btn div div:last-child {
                font-size: 0.6rem;
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }
            
            .stats-grid > div {
                padding: 1rem !important;
            }
            
            .stats-grid > div > div {
                flex-direction: column !important;
                text-align: center !important;
                gap: 0.75rem !important;
            }
            
            .stats-grid h3 {
                font-size: 0.8rem !important;
            }
            
            .stats-grid p {
                font-size: 1.4rem !important;
            }
            
            .stats-grid span {
                font-size: 0.7rem !important;
            }
            
            .stats-grid .icon-circle {
                width: 40px !important;
                height: 40px !important;
                font-size: 1.2rem !important;
            }
            
            .chart-container {
                padding: 0.75rem !important;
                margin-bottom: 1rem !important;
            }
            
            .chart-container h3 {
                font-size: 1rem !important;
                margin-bottom: 0.75rem !important;
            }
            
            .charts-grid {
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .action-btn {
                padding: 0.75rem 0.5rem;
                gap: 0.5rem;
                font-size: 0.85rem;
            }
            
            .action-btn i {
                font-size: 1.2rem !important;
            }
            
            .action-btn div div:first-child {
                font-size: 0.85rem;
            }
            
            .action-btn div div:last-child {
                font-size: 0.7rem;
            }
            
            .transaction-item {
                padding: 0.5rem 0;
            }
            
            .transaction-item .icon-circle {
                width: 30px !important;
                height: 30px !important;
                font-size: 0.8rem !important;
            }
            
            .transaction-item .transaction-title {
                font-size: 0.85rem;
            }
            
            .transaction-item .transaction-date {
                font-size: 0.7rem;
            }
            
            .transaction-item .transaction-amount {
                font-size: 0.8rem;
            }
        }
        
        /* Fix for very small screens */
        @media (max-width: 360px) {
            .transaction-item {
                padding: 0.4rem 0;
                flex-wrap: wrap;
            }
            
            .transaction-item .icon-circle {
                width: 25px !important;
                height: 25px !important;
                font-size: 0.7rem !important;
            }
            
            .transaction-item .transaction-title {
                font-size: 0.75rem;
            }
            
            .transaction-item .transaction-date {
                font-size: 0.65rem;
            }
            
            .transaction-item .transaction-amount {
                font-size: 0.7rem;
                margin-left: 0.25rem;
            }
            
            .charts-grid {
                gap: 0.75rem;
                margin-bottom: 1rem;
            }
        }
    </style>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Pemasukan</h3>
                    <p style="font-size: 1.75rem; font-weight: bold; color: #28a745;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                    <span style="color: {{ $incomeChange >= 0 ? '#28a745' : '#dc3545' }}; font-size: 0.8rem;">
                        {{ $incomeChange >= 0 ? '↗' : '↘' }} {{ $incomeChange >= 0 ? '+' : '' }}{{ number_format($incomeChange, 1) }}% dari bulan lalu
                    </span>
                </div>
                <div class="icon-circle" style="background: #28a745; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;"><i class="fas fa-arrow-up"></i></div>
            </div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #dc3545;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Pengeluaran</h3>
                    <p style="font-size: 1.75rem; font-weight: bold; color: #dc3545;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                    <span style="color: {{ $expenseChange >= 0 ? '#dc3545' : '#28a745' }}; font-size: 0.8rem;">
                        {{ $expenseChange >= 0 ? '↗' : '↘' }} {{ $expenseChange >= 0 ? '+' : '' }}{{ number_format($expenseChange, 1) }}% dari bulan lalu
                    </span>
                </div>
                <div class="icon-circle" style="background: #dc3545; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;"><i class="fas fa-arrow-down"></i></div>
            </div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid var(--blue-dark);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Saldo Bersih</h3>
                    <p style="font-size: 1.75rem; font-weight: bold; color: var(--blue-dark);">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                    <span style="color: {{ $balanceChange >= 0 ? '#28a745' : '#dc3545' }}; font-size: 0.8rem;">
                        {{ $balanceChange >= 0 ? '↗' : '↘' }} {{ $balanceChange >= 0 ? '+' : '' }}{{ number_format($balanceChange, 1) }}% dari bulan lalu
                    </span>
                </div>
                <div class="icon-circle" style="background: var(--blue-dark); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;"><i class="fas fa-wallet"></i></div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="chart-container">
        <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Tren Bulanan</h3>
        <canvas id="monthlyChart" style="max-height: 300px;"></canvas>
    </div>
    
    <div class="charts-grid">
        <!-- Category Pie Chart -->
        <div class="chart-container">
            <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Kategori Pengeluaran</h3>
            <canvas id="categoryChart" style="max-height: 250px;"></canvas>
        </div>
        
        <!-- Recent Transactions -->
        <div class="chart-container">
            <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Transaksi Terbaru</h3>
            <div style="space-y: 0.75rem;">
                @forelse($recentTransactions as $transaction)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f3f4;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0;">
                        <div class="icon-circle" style="background: {{ $transaction->type === 'income' ? '#28a745' : '#dc3545' }}; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                            <i class="{{ $transaction->category->icon }}"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div class="transaction-title" style="font-weight: 500; color: var(--blue-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $transaction->description }}</div>
                            <div class="transaction-date" style="font-size: 0.8rem; color: #6c757d;">{{ $transaction->transaction_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="transaction-amount" style="color: {{ $transaction->type === 'income' ? '#28a745' : '#dc3545' }}; font-weight: 600; white-space: nowrap; margin-left: 0.5rem;">
                        {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                </div>
                @empty
                <div style="padding: 2rem; text-align: center; color: #6c757d;">
                    Belum ada transaksi
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Aksi Cepat</h3>
        <div class="quick-actions">
            <button class="action-btn" style="background: linear-gradient(135deg, #28a745, #20c997); color: white;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-plus-circle" style="font-size: 1.5rem;"></i>
                <div style="text-align: left;">
                    <div>Tambah Pemasukan</div>
                    <div style="font-size: 0.8rem; opacity: 0.9;">Catat pendapatan baru</div>
                </div>
            </button>
            
            <button class="action-btn" style="background: linear-gradient(135deg, #dc3545, #e74c3c); color: white;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-minus-circle" style="font-size: 1.5rem;"></i>
                <div style="text-align: left;">
                    <div>Tambah Pengeluaran</div>
                    <div style="font-size: 0.8rem; opacity: 0.9;">Catat pengeluaran baru</div>
                </div>
            </button>
            
            <button class="action-btn" style="background: linear-gradient(135deg, var(--orange), #e6741a); color: white;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-chart-bar" style="font-size: 1.5rem;"></i>
                <div style="text-align: left;">
                    <div>Lihat Laporan</div>
                    <div style="font-size: 0.8rem; opacity: 0.9;">Analisis keuangan</div>
                </div>
            </button>
        </div>
    </div>
    
    <script>
        // Monthly Trend Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyData = @json($monthlyData);
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: 'Pemasukan',
                    data: monthlyData.map(item => item.income),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Pengeluaran',
                    data: monthlyData.map(item => item.expense),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000) + 'K';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Category Pie Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = @json($categoryData);
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category.name),
                datasets: [{
                    data: categoryData.map(item => item.total),
                    backgroundColor: [
                        '#ff821c',
                        '#003e7f', 
                        '#ffde59',
                        '#28a745',
                        '#dc3545',
                        '#6f42c1',
                        '#fd7e14',
                        '#20c997'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</x-layouts.app>