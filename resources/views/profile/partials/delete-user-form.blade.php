<section>
    <header style="margin-bottom: 1.5rem;">
        <h3 style="color: #dc3545; font-weight: 600; margin-bottom: 0.5rem;">
            <i class="fas fa-trash-alt" style="margin-right: 0.5rem;"></i>
            Hapus Akun
        </h3>
        <p style="color: #6c757d; font-size: 0.9rem;">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.
        </p>
    </header>

    <button 
        onclick="openDeleteModal()" 
        style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;"
    >
        <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
        Hapus Akun
    </button>

    <!-- Modal Konfirmasi -->
    <div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px;">
            <h3 style="color: #dc3545; margin-bottom: 1rem; font-weight: 600;">
                <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
                Konfirmasi Hapus Akun
            </h3>
            <p style="color: #6c757d; margin-bottom: 1.5rem; font-size: 0.9rem;">
                Apakah Anda yakin ingin menghapus akun? Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen. Masukkan password Anda untuk mengkonfirmasi.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">Password</label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Masukkan password Anda"
                        required 
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;"
                    />
                    @error('password', 'userDeletion')
                        <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button 
                        type="button" 
                        onclick="closeDeleteModal()" 
                        style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer;"
                    >
                        <i class="fas fa-trash-alt" style="margin-right: 0.5rem;"></i>
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
</section>