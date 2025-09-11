<x-layouts.app title="Pengaturan Profil">
    <div style="margin-bottom: 2rem;">
        <h2 style="color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem;">Pengaturan Profil</h2>
        <p style="color: #6c757d;">Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    <div style="display: grid; gap: 1.5rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            @include('profile.partials.update-password-form')
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-layouts.app>
