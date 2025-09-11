<x-layouts.auth title="Lupa Password" subtitle="Reset password Anda">
    <div style="background: #e3f2fd; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; color: #1565c0;">
        Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="success-message">
            {{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" 
                   placeholder="Masukkan email Anda" required autofocus>
        </div>

        <button type="submit" class="btn-primary" id="forgotBtn">
            Kirim Link Reset
        </button>

        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">← Kembali ke halaman masuk</a>
        </div>
    </form>

    <script>
        document.getElementById('forgotForm').addEventListener('submit', function() {
            const btn = document.getElementById('forgotBtn');
            btn.classList.add('btn-loading');
            btn.disabled = true;
        });
    </script>
</x-layouts.auth>