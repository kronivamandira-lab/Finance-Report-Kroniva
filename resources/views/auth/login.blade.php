<x-layouts.auth title="Masuk" subtitle="Masuk ke akun Anda">
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

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" 
                   placeholder="Masukkan email Anda" required autofocus autocomplete="username">
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" 
                   placeholder="Masukkan password Anda" required autocomplete="current-password">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
            <label for="remember_me" class="checkbox-label">Ingat saya</label>
        </div>

        <button type="submit" class="btn-primary" id="loginBtn">
            Masuk
        </button>

        <div class="auth-links">
            <span style="color: #6c757d; font-size: 0.9rem;">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
        </div>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('btn-loading');
            btn.disabled = true;
        });
    </script>
</x-layouts.auth>