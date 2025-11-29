<div class="sidebar">

    <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo PT Pasifik Energi Trans">

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
    <a href="{{ route('karyawan.id-card', ['id' => Auth::user()->karyawan_id]) }}" target="_blank"
       class="{{ request()->routeIs('karyawan.id-card') ? 'active' : '' }}"
       style="{{ request()->routeIs('karyawan.id-card') ? 'background: #2b39a0;' : '' }}">
        <i class="fas fa-download me-2"></i>Cetak Kartu Karyawan
    </a>

    <div style="position:absolute; bottom:20px; width:100%;">
        <a href="{{ route('logout') }}" class="logout-btn">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
    </div>
    
</div>
