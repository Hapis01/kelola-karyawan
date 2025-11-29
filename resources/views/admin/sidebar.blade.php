<div class="sidebar">

    <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo PT Pasifik Energi Trans">

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
    <a href="{{ route('admin.report') }}" 
       class="{{ request()->routeIs('admin.report') ? 'active' : '' }}"
       style="{{ request()->routeIs('admin.report') ? 'background: #2b39a0;' : '' }}">
        <i class="fas fa-file-pdf me-2"></i>Cetak Laporan
    </a>

    <div style="position:absolute; bottom:20px; width:100%;">
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

