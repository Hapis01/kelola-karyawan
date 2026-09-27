<div class="sidebar">

    <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo PT Pasifik Energi Trans">

    <!-- Scrollable Menu Container -->
    <div class="sidebar-menu">
        <!-- Menu Utama -->
        <h6 style="color: #99a3b3; font-size: 0.75rem; padding: 12px 25px 8px; margin: 10px 0 0 0; font-weight: 600; text-transform: uppercase;">
            Menu Utama
        </h6>
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.dashboard') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-users me-2"></i>Lihat Daftar Karyawan
        </a>
        <a href="{{ route('admin.history') }}"
           class="{{ request()->routeIs('admin.history') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.history') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-history me-2"></i>History Karyawan
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.users.index') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-key me-2"></i>Kelola User
        </a>

        <!-- Menu Manajemen Fitur -->
        <h6 style="color: #99a3b3; font-size: 0.75rem; padding: 12px 25px 8px; margin: 15px 0 0 0; font-weight: 600; text-transform: uppercase;">
            Manajemen Fitur
        </h6>
        <a href="{{ route('admin.training.index') }}"
           class="{{ request()->routeIs('admin.training.index') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.training.index') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-certificate me-2"></i>Sertifikat Karyawan
        </a>
        <a href="{{ route('admin.leave.index') }}"
           class="{{ request()->routeIs('admin.leave.index') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.leave.index') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-calendar-times me-2"></i>Permintaan Cuti
        </a>
        <a href="{{ route('admin.profile-updates.index') }}"
           class="{{ request()->routeIs('admin.profile-updates.index') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.profile-updates.index') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-user-edit me-2"></i>Update Profil
        </a>

        <!-- Menu Notifikasi -->
        <h6 style="color: #99a3b3; font-size: 0.75rem; padding: 12px 25px 8px; margin: 15px 0 0 0; font-weight: 600; text-transform: uppercase;">
            Notifikasi
        </h6>
        <a href="{{ route('admin.notifications.index') }}"
           class="{{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.notifications.index') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-bell me-2"></i>Pusat Notifikasi
            <span id="notification-badge" class="badge bg-danger" style="margin-left: auto; display: none;">0</span>
        </a>

        <!-- Menu Laporan -->
        <h6 style="color: #99a3b3; font-size: 0.75rem; padding: 12px 25px 8px; margin: 15px 0 0 0; font-weight: 600; text-transform: uppercase;">
            Laporan
        </h6>
        <a href="{{ route('admin.report') }}"
           class="{{ request()->routeIs('admin.report') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.report') ? 'background: #2b39a0;' : '' }}">
            <i class="fas fa-file-pdf me-2"></i>Cetak Laporan
        </a>
    </div>

    <!-- Profile & Logout Section -->
    <div class="sidebar-footer">
        <a href="{{ route('admin.profile') }}"
           class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}"
           style="{{ request()->routeIs('admin.profile') ? 'background: #2b39a0;' : 'background:#0a0f46;' }}">
            <i class="fas fa-user-circle me-2"></i>Profile (Admin)
        </a>
        <a href="{{ route('logout') }}" class="logout-btn">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
    </div>

</div>

<!-- Notification Toast (Global) -->
<div id="notificationToast" class="notification-toast">
    <div class="toast-content">
        <i class="fas fa-bell me-2"></i>
        <span id="toastMessage">Ada pesan masuk</span>
    </div>
</div>
