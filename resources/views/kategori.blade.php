<x-layouts.app title="Kategori">
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
        {{ session('success') }}
    </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem;">Kelola Kategori</h2>
            <p style="color: #6c757d;">Atur kategori untuk mengelompokkan transaksi Anda</p>
        </div>
        <button style="background: var(--orange); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;" onclick="openModal('addModal')">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background: #28a745; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin: 0;">Pemasukan</h3>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #28a745; margin: 0;">{{ $categories->where('type', 'income')->count() }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid #dc3545;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background: #dc3545; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin: 0;">Pengeluaran</h3>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #dc3545; margin: 0;">{{ $categories->where('type', 'expense')->count() }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-left: 4px solid var(--orange);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background: var(--orange); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h3 style="color: #6c757d; font-size: 0.9rem; margin: 0;">Total</h3>
                    <p style="font-size: 1.5rem; font-weight: bold; color: var(--orange); margin: 0;">{{ $categories->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 250px;">
                <input type="text" placeholder="🔍 Cari kategori..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;" id="searchInput">
            </div>
            <div>
                <select id="typeFilter" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; min-width: 150px; font-size: 0.9rem;">
                    <option value="">📋 Semua Tipe</option>
                    <option value="income">💰 Pemasukan</option>
                    <option value="expense">💸 Pengeluaran</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background: #f8f9fa; padding: 1rem; border-bottom: 1px solid #dee2e6;">
            <h3 style="margin: 0; color: var(--blue-dark); font-weight: 600;">
                <i class="fas fa-list" style="margin-right: 0.5rem;"></i>
                Daftar Kategori
            </h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--blue-dark); border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Kategori
                        </th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--blue-dark); border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-exchange-alt" style="margin-right: 0.5rem;"></i>Tipe
                        </th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--blue-dark); border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Deskripsi
                        </th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--blue-dark); border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-chart-bar" style="margin-right: 0.5rem;"></i>Transaksi
                        </th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--blue-dark); border-bottom: 1px solid #dee2e6;">
                            <i class="fas fa-cogs" style="margin-right: 0.5rem;"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="categoryTable">
                    @forelse($categories as $category)
                    <tr class="category-row" data-type="{{ $category->type }}" style="border-bottom: 1px solid #f1f3f4; transition: background-color 0.2s;">
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="background: {{ $category->type === 'income' ? '#28a745' : '#dc3545' }}; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="{{ $category->icon }}" style="font-size: 1rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--blue-dark);">{{ $category->name }}</div>
                                    <div style="font-size: 0.8rem; color: #6c757d;">{{ $category->icon }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <span style="background: {{ $category->type === 'income' ? '#28a745' : '#dc3545' }}; color: white; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                {{ $category->type === 'income' ? '💰 Pemasukan' : '💸 Pengeluaran' }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="color: #6c757d; font-size: 0.9rem;">
                                {{ $category->description ?: 'Tidak ada deskripsi' }}
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <div style="background: #f8f9fa; padding: 0.4rem 0.8rem; border-radius: 20px; display: inline-block;">
                                <span style="font-weight: 600; color: var(--blue-dark);">{{ $category->transactions_count ?? 0 }}</span>
                                <span style="font-size: 0.8rem; color: #6c757d;">transaksi</span>
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->type }}', '{{ $category->icon }}', '{{ $category->description }}')" 
                                        style="background: var(--orange); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; gap: 0.25rem;"
                                        title="Edit kategori">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('kategori.destroy', $category) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('⚠️ Yakin hapus kategori \"{{ $category->name }}\"?\n\nSemua transaksi dengan kategori ini akan kehilangan kategorinya.')" 
                                            style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; gap: 0.25rem;"
                                            title="Hapus kategori">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: #6c757d;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                                <i class="fas fa-folder-open" style="font-size: 3rem; opacity: 0.3;"></i>
                                <div>
                                    <h4 style="margin: 0; color: #6c757d;">Belum ada kategori</h4>
                                    <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Tambahkan kategori pertama Anda untuk mulai mengelompokkan transaksi</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add -->
    <div id="addModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: var(--orange); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h3 style="margin: 0; color: var(--blue-dark);">Tambah Kategori Baru</h3>
                    <p style="margin: 0; color: #6c757d; font-size: 0.9rem;">Buat kategori untuk mengelompokkan transaksi</p>
                </div>
            </div>
            
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Nama Kategori
                    </label>
                    <input type="text" name="name" placeholder="Contoh: Makanan, Gaji, Transportasi" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-exchange-alt" style="margin-right: 0.5rem;"></i>Tipe Kategori
                    </label>
                    <select name="type" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;">
                        <option value="">Pilih tipe kategori</option>
                        <option value="income">💰 Pemasukan (uang masuk)</option>
                        <option value="expense">💸 Pengeluaran (uang keluar)</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-icons" style="margin-right: 0.5rem;"></i>Icon FontAwesome
                    </label>
                    <input type="text" name="icon" placeholder="fas fa-utensils, fas fa-car, fas fa-home" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;">
                    <small style="color: #6c757d; font-size: 0.8rem;">
                        Gunakan class FontAwesome. Contoh: fas fa-utensils untuk makanan
                    </small>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Deskripsi (Opsional)
                    </label>
                    <textarea name="description" placeholder="Deskripsi singkat tentang kategori ini..." 
                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; height: 80px; resize: vertical; font-size: 0.9rem;"></textarea>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal('addModal')" 
                            style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-times" style="margin-right: 0.5rem;"></i>Batal
                    </button>
                    <button type="submit" 
                            style="background: var(--orange); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-save" style="margin-right: 0.5rem;"></i>Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: var(--orange); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h3 style="margin: 0; color: var(--blue-dark);">Edit Kategori</h3>
                    <p style="margin: 0; color: #6c757d; font-size: 0.9rem;">Perbarui informasi kategori</p>
                </div>
            </div>
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-tag" style="margin-right: 0.5rem;"></i>Nama Kategori
                    </label>
                    <input type="text" id="editName" name="name" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-exchange-alt" style="margin-right: 0.5rem;"></i>Tipe Kategori
                    </label>
                    <select id="editType" name="type" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;">
                        <option value="income">💰 Pemasukan</option>
                        <option value="expense">💸 Pengeluaran</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-icons" style="margin-right: 0.5rem;"></i>Icon FontAwesome
                    </label>
                    <input type="text" id="editIcon" name="icon" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">
                        <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Deskripsi
                    </label>
                    <textarea id="editDescription" name="description" 
                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; height: 80px; resize: vertical; font-size: 0.9rem;"></textarea>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal('editModal')" 
                            style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-times" style="margin-right: 0.5rem;"></i>Batal
                    </button>
                    <button type="submit" 
                            style="background: var(--orange); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-save" style="margin-right: 0.5rem;"></i>Update Kategori
                    </button>
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

        function editCategory(id, name, type, icon, description) {
            document.getElementById('editForm').action = '/kategori/' + id;
            document.getElementById('editName').value = name;
            document.getElementById('editType').value = type;
            document.getElementById('editIcon').value = icon;
            document.getElementById('editDescription').value = description || '';
            openModal('editModal');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.category-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Type filter functionality
        document.getElementById('typeFilter').addEventListener('change', function() {
            const selectedType = this.value;
            const rows = document.querySelectorAll('.category-row');
            
            rows.forEach(row => {
                const rowType = row.getAttribute('data-type');
                row.style.display = selectedType === '' || rowType === selectedType ? '' : 'none';
            });
        });

        // Row hover effect
        document.querySelectorAll('.category-row').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    </script>
</x-layouts.app>