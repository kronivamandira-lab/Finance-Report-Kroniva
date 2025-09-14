<x-layouts.app title="Laporan">
    <div style="margin-bottom: 2rem;">
        <h2 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem;">Laporan Keuangan {{ $selectedYear }}</h2>
        <p style="color: #6c757d;">Analisis dan ringkasan keuangan Anda untuk tahun {{ $selectedYear }}</p>
    </div>

    <!-- Filter & Export -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <form method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <label style="font-weight: 500; color: var(--blue-dark);">Tahun:</label>
                    <select name="year" onchange="this.form.submit()" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; min-width: 120px;">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="color: #6c757d; font-size: 0.9rem;">
                    Menampilkan data untuk tahun {{ $selectedYear }}
                </div>
            </div>
            <a href="{{ route('laporan.export-pdf', ['year' => $selectedYear]) }}" style="background: var(--orange); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center;">
                <i class="fas fa-file-pdf" style="margin-right: 0.5rem;"></i>Export PDF
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Pemasukan</h3>
                    <p style="font-size: 1.75rem; font-weight: bold; color: #28a745;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                    <span style="color: {{ $incomeChangeYear >= 0 ? '#28a745' : '#dc3545' }}; font-size: 0.8rem;">
                        {{ $incomeChangeYear >= 0 ? '↗' : '↘' }} {{ $incomeChangeYear >= 0 ? '+' : '' }}{{ number_format($incomeChangeYear, 1) }}% dari tahun {{ $selectedYear - 1 }}
                    </span>
                </div>
                <div style="background: #28a745; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💰</div>
            </div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #dc3545;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Pengeluaran</h3>
                    <p style="font-size: 1.75rem; font-weight: bold; color: #dc3545;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                    <span style="color: {{ $expenseChangeYear >= 0 ? '#dc3545' : '#28a745' }}; font-size: 0.8rem;">
                        {{ $expenseChangeYear >= 0 ? '↗' : '↘' }} {{ $expenseChangeYear >= 0 ? '+' : '' }}{{ number_format($expenseChangeYear, 1) }}% dari tahun {{ $selectedYear - 1 }}
                    </span>
                </div>
                <div style="background: #dc3545; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💸</div>
            </div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid var(--blue-dark);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Saldo Bersih</h3>
                    <p style="font-size: 1.75rem; font-weight: bold; color: var(--blue-dark);">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                    <span style="color: {{ $balanceChangeYear >= 0 ? '#28a745' : '#dc3545' }}; font-size: 0.8rem;">
                        {{ $balanceChangeYear >= 0 ? '↗' : '↘' }} {{ $balanceChangeYear >= 0 ? '+' : '' }}{{ number_format($balanceChangeYear, 1) }}% dari tahun {{ $selectedYear - 1 }}
                    </span>
                </div>
                <div style="background: var(--blue-dark); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💳</div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Tren Keuangan Bulanan</h3>
            <canvas id="trendChart" style="max-height: 400px;"></canvas>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Kategori Pengeluaran</h3>
            <canvas id="categoryChart" style="max-height: 300px;"></canvas>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Perbandingan Bulanan</h3>
            <canvas id="comparisonChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Top Categories -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 1rem;">Kategori Teratas</h3>
        <div style="display: grid; gap: 1rem;">
            @forelse($expenseByCategory->sortByDesc('total')->take(5) as $categoryData)
            @php
                $percentage = $totalExpense > 0 ? ($categoryData->total / $totalExpense) * 100 : 0;
                $transactionCount = \App\Models\Transaction::where('user_id', auth()->id())
                    ->where('category_id', $categoryData->category_id)
                    ->count();
            @endphp
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="background: #dc3545; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="{{ $categoryData->category->icon }}"></i>
                    </div>
                    <div>
                        <div style="font-weight: 500;">{{ $categoryData->category->name }}</div>
                        <div style="font-size: 0.8rem; color: #6c757d;">{{ number_format($percentage, 1) }}% dari total pengeluaran</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 600; color: #dc3545;">Rp {{ number_format($categoryData->total, 0, ',', '.') }}</div>
                    <div style="font-size: 0.8rem; color: #6c757d;">{{ $transactionCount }} transaksi</div>
                </div>
            </div>
            @empty
            <div style="padding: 2rem; text-align: center; color: #6c757d;">
                Belum ada data pengeluaran
            </div>
            @endforelse
        </div>
    </div>

    <script>
        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const trendData = @json($monthlyTrendData);
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.map(item => item.month),
                datasets: [{
                    label: 'Pemasukan',
                    data: trendData.map(item => item.income),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Pengeluaran',
                    data: trendData.map(item => item.expense),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Saldo',
                    data: trendData.map(item => item.income - item.expense),
                    borderColor: '#003e7f',
                    backgroundColor: 'rgba(0, 62, 127, 0.1)',
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
                },
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
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = @json($expenseByCategory);
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category.name),
                datasets: [{
                    data: categoryData.map(item => item.total),
                    backgroundColor: ['#ff821c', '#28a745', '#003e7f', '#ffde59', '#dc3545', '#6f42c1', '#fd7e14', '#20c997'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Comparison Chart
        const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
        const comparisonData = @json($comparisonData);
        new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: comparisonData.map(item => item.month),
                datasets: [{
                    label: 'Pemasukan',
                    data: comparisonData.map(item => item.income),
                    backgroundColor: '#28a745'
                }, {
                    label: 'Pengeluaran',
                    data: comparisonData.map(item => item.expense),
                    backgroundColor: '#dc3545'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
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
                },
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
                }
            }
        });
    </script>
</x-layouts.app>