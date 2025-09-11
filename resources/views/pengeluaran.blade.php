<x-layouts.app title="Pengeluaran">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem;">Data Pengeluaran</h2>
            <p style="color: #6c757d;">Kelola semua pengeluaran Anda</p>
        </div>
        <button style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;" onclick="openModal('addModal')">
            <span>+</span> Tambah Pengeluaran
        </button>
    </div>

    <!-- Search & Filter -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <input type="text" placeholder="Cari pengeluaran..." style="flex: 1; min-width: 200px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;" id="searchInput">
            <select id="categoryFilter" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; min-width: 150px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="date" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #dc3545;">
            <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Pengeluaran</h3>
            <p style="font-size: 1.5rem; font-weight: bold; color: #dc3545;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid var(--orange);">
            <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Bulan Ini</h3>
            <p style="font-size: 1.5rem; font-weight: bold; color: var(--orange);">Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</p>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid var(--blue-dark);">
            <h3 style="color: #6c757d; font-size: 0.9rem; margin-bottom: 0.5rem;">Rata-rata</h3>
            <p style="font-size: 1.5rem; font-weight: bold; color: var(--blue-dark);">Rp {{ number_format($avgExpense, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--blue-dark);">Tanggal</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--blue-dark);">Deskripsi</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--blue-dark);">Kategori</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--blue-dark);">Jumlah</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--blue-dark);">Aksi</th>
                    </tr>
                </thead>
                <tbody id="expenseTable">
                    @forelse($transactions as $transaction)
                    <tr style="border-bottom: 1px solid #f1f3f4;">
                        <td style="padding: 1rem;">{{ $transaction->transaction_date->format('d M Y') }}</td>
                        <td style="padding: 1rem;">{{ $transaction->description }}</td>
                        <td style="padding: 1rem;">
                            <span style="background: #dc3545; color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                <i class="{{ $transaction->category->icon }}"></i> {{ $transaction->category->name }}
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: right; font-weight: 600; color: #dc3545;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td style="padding: 1rem; text-align: center;">
                            <button onclick="editTransaction({{ $transaction->id }}, '{{ $transaction->description }}', {{ $transaction->amount }}, '{{ $transaction->transaction_date->format('Y-m-d') }}', {{ $transaction->category_id }})" style="background: var(--orange); color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; margin-right: 0.25rem; cursor: pointer;">Edit</button>
                            <form action="{{ route('transaksi.destroy', $transaction) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus transaksi ini?')" style="background: #dc3545; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; cursor: pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #6c757d;">Belum ada data pengeluaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div id="addModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
            <h3 style="color: var(--blue-dark); margin-bottom: 1.5rem;">Tambah Pengeluaran</h3>
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="expense">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal</label>
                    <input type="date" name="transaction_date" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Deskripsi</label>
                    <input type="text" name="description" placeholder="Masukkan deskripsi" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kategori</label>
                    <select name="category_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jumlah</label>
                    <input type="number" name="amount" placeholder="0" min="0" step="0.01" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal('addModal')" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;">Batal</button>
                    <button type="submit" style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
            <h3 style="color: var(--blue-dark); margin-bottom: 1.5rem;">Edit Pengeluaran</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="expense">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal</label>
                    <input type="date" id="editDate" name="transaction_date" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Deskripsi</label>
                    <input type="text" id="editDescription" name="description" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kategori</label>
                    <select id="editCategory" name="category_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jumlah</label>
                    <input type="number" id="editAmount" name="amount" min="0" step="0.01" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal('editModal')" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;">Batal</button>
                    <button type="submit" style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#expenseTable tr');
            
            rows.forEach(row => {
                if (row.children.length > 1) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                }
            });
        });

        // Category filter functionality
        document.getElementById('categoryFilter').addEventListener('change', function() {
            const selectedCategory = this.value.toLowerCase();
            const rows = document.querySelectorAll('#expenseTable tr');
            
            rows.forEach(row => {
                if (row.children.length > 1) {
                    const categoryText = row.children[2].textContent.toLowerCase();
                    row.style.display = selectedCategory === '' || categoryText.includes(selectedCategory) ? '' : 'none';
                }
            });
        });

        // Edit transaction function
        function editTransaction(id, description, amount, date, categoryId) {
            document.getElementById('editForm').action = '/transaksi/' + id;
            document.getElementById('editDescription').value = description;
            document.getElementById('editAmount').value = amount;
            document.getElementById('editDate').value = date;
            document.getElementById('editCategory').value = categoryId;
            openModal('editModal');
        }
    </script>
</x-layouts.app>