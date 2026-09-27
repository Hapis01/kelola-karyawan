<div class="sidebar">

    <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo PT Pasifik Energi Trans">

    <!-- Scrollable Menu Container -->
    <div class="sidebar-menu">
        <!-- Menu Utama -->
        <h6 style="color: #99a3b3; font-size: 0.75rem; padding: 12px 25px 8px; margin: 10px 0 0 0; font-weight: 600; text-transform: uppercase;">
            Menu Utama
        </h6>
        <a href="{{ route('karyawan.dashboard') }}"
           class="{{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}"
           style="{{ request()->routeIs('karyawan.dashboard') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-home me-2"></i>Dashboard Saya
        </a>
        <a href="{{ route('karyawan.profile') }}"
           class="{{ request()->routeIs('karyawan.profile') ? 'active' : '' }}"
           style="{{ request()->routeIs('karyawan.profile') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-user me-2"></i>Profil Saya
        </a>
        <a href="{{ route('karyawan.id-card', Auth::user()->nik) }}" target="_blank"
           class="{{ request()->routeIs('karyawan.id-card') ? 'active' : '' }}"
           style="{{ request()->routeIs('karyawan.id-card') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-download me-2"></i>Cetak Kartu Karyawan
        </a>

        <!-- Menu Fitur Saya -->
        <h6 style="color: #99a3b3; font-size: 0.75rem; padding: 12px 25px 8px; margin: 15px 0 0 0; font-weight: 600; text-transform: uppercase;">
            Fitur Saya
        </h6>
        <a href="{{ route('karyawan.training.index') }}"
           class="{{ request()->routeIs('karyawan.training.*') ? 'active' : '' }}"
           style="{{ request()->routeIs('karyawan.training.*') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-certificate me-2"></i>Sertifikat
        </a>
        <a href="{{ route('karyawan.leave.index') }}"
           class="{{ request()->routeIs('karyawan.leave.*') ? 'active' : '' }}"
           style="{{ request()->routeIs('karyawan.leave.*') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-calendar-times me-2"></i>Permintaan Cuti
        </a>
        <a href="{{ route('karyawan.profile.edit') }}"
           class="{{ request()->routeIs('karyawan.profile.edit') ? 'active' : '' }}"
           style="{{ request()->routeIs('karyawan.profile.edit') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-user-edit me-2"></i>Edit Profil
        </a>
    </div>

    <!-- Profile & Logout Section -->
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="logout-btn">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
    </div>

</div>
