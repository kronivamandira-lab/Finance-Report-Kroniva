<section>
    <header style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem;">
            <i class="fas fa-lock" style="margin-right: 0.5rem;"></i>
            Ubah Password
        </h3>
        <p style="color: #6c757d; font-size: 0.9rem;">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div style="margin-bottom: 1rem;">
            <label for="update_password_current_password" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">Password Saat Ini</label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;"
            />
            @error('current_password', 'updatePassword')
                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="update_password_password" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">Password Baru</label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;"
            />
            @error('password', 'updatePassword')
                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="update_password_password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">Konfirmasi Password</label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;"
            />
            @error('password_confirmation', 'updatePassword')
                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button 
                type="submit" 
                style="background: var(--blue-dark); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;"
            >
                <i class="fas fa-key" style="margin-right: 0.5rem;"></i>
                Ubah Password
            </button>

            @if (session('status') === 'password-updated')
                <p style="color: #28a745; font-size: 0.9rem;">
                    <i class="fas fa-check-circle" style="margin-right: 0.25rem;"></i>
                    Password berhasil diubah!
                </p>
            @endif
        </div>
    </form>
</section>