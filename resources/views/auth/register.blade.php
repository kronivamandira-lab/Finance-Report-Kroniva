<x-layouts.auth title="Daftar" subtitle="Buat akun baru Anda">
    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" 
                   placeholder="Masukkan nama lengkap Anda" required autofocus autocomplete="name">
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" 
                   placeholder="Masukkan email Anda" required autocomplete="username">
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" 
                   placeholder="Minimal 8 karakter" required autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" 
                   placeholder="Ulangi password Anda" required autocomplete="new-password">
        </div>

        <!-- Terms Agreement -->
        <div class="checkbox-group">
            <input id="terms" type="checkbox" class="checkbox-input" required>
            <label for="terms" class="checkbox-label">
                Saya setuju dengan <a href="#" class="auth-link">syarat dan ketentuan</a>
            </label>
        </div>

        <button type="submit" class="btn-primary" id="registerBtn">
            Daftar Sekarang
        </button>

        <div class="auth-links">
            <span style="color: #6c757d; font-size: 0.9rem;">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </div>
    </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            btn.classList.add('btn-loading');
            btn.disabled = true;
        });

        // Password strength indicator
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        
        password.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            // Add visual feedback here if needed
        });

        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });

        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }
    </script>
</x-layouts.auth>