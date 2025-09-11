<section>
    <header style="margin-bottom: 1.5rem;">
        <h3 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem;">
            <i class="fas fa-user" style="margin-right: 0.5rem;"></i>
            Informasi Profil
        </h3>
        <p style="color: #6c757d; font-size: 0.9rem;">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div style="margin-bottom: 1rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">Nama</label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;"
            />
            @error('name')
                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--blue-dark);">Email</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email', $user->email) }}" 
                required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem;"
            />
            @error('email')
                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button 
                type="submit" 
                style="background: var(--orange); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;"
            >
                <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p style="color: #28a745; font-size: 0.9rem;">
                    <i class="fas fa-check-circle" style="margin-right: 0.25rem;"></i>
                    Tersimpan!
                </p>
            @endif
        </div>
    </form>
</section>