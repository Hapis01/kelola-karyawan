@extends('admin.layout')

@section('content')

<h3 class="fw-bold mb-3">Kelola Akun User</h3>
<p class="mb-4">Kelola akun login user/karyawan untuk sistem PT PASIFIK ENERGI TRANS.</p>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-card card-hover fade-in-up">
            <div class="fw-bold text-muted small">Total User</div>
            <h2 class="fw-bold text-primary">{{ $total }}</h2>
        </div>
    </div>
</div>

<!-- Tombol Tambah -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-primary btn-add fade-in-up" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fas fa-plus me-2"></i>Tambah User
    </button>
    
    <div class="text-muted small">
        Menampilkan {{ $users->count() }} dari {{ $users->total() }} hasil
    </div>
</div>

<!-- Filter Section -->
<div class="card filter-card mb-4 fade-in-up">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control search-input" placeholder="Cari nama atau email...">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="table-container fade-in-up">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">Role</th>
                    <th style="width: 15%;">NIK / Karyawan</th>
                    <th style="width: 15%;">Terdaftar</th>
                    <th style="width: 15%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $key => $user)
                <tr class="table-row-animate" style="animation-delay: {{ ($key * 0.05) }}s;">
                    <td class="fw-bold">{{ $users->firstItem() + $key }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-small" style="background: linear-gradient(135deg, #0d0b61, #1a1785); color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-500">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-info">Karyawan</span>
                        @endif
                    </td>
                    <td>
                        @if($user->nik)
                            <small class="text-muted">{{ $user->nik }}</small>
                            @if($user->karyawan)
                                <br>
                                <small class="fw-500">{{ $user->karyawan->nama }}</small>
                            @endif
                        @else
                            <small class="text-muted">-</small>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </small>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editUserModal" 
                                onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->nik }}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        @if($user->id !== auth()->id() && !($user->role === 'admin' && auth()->user()->role === 'admin'))
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-danger" disabled title="{{ $user->id === auth()->id() ? 'Anda tidak bisa menghapus akun sendiri' : 'Anda tidak bisa menghapus akun admin lain' }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox me-2"></i> Tidak ada data user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
        </small>
        <nav>
            {{ $users->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email aktif" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" id="addRoleSelect" required onchange="handleRoleChange('add')">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="karyawan" {{ old('role') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="nikFieldAdd" style="display: none;">
                        <label class="form-label fw-600">NIK Karyawan <span class="text-danger">*</span></label>
                        <select class="form-select @error('nik') is-invalid @enderror" name="nik" id="nikSelect">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->nik }}" {{ old('nik') === $k->nik ? 'selected' : '' }}>
                                    {{ $k->nik }} - {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('nik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Ulangi password" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="fas fa-save me-2"></i>Tambah User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email aktif" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" id="editRoleSelect" required onchange="handleRoleChange('edit')">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="nikFieldEdit" style="display: none;">
                        <label class="form-label fw-600">NIK Karyawan <span class="text-danger">*</span></label>
                        <select class="form-select @error('nik') is-invalid @enderror" name="nik" id="nikSelectEdit">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->nik }}">
                                    {{ $k->nik }} - {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('nik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Password Baru (Opsional)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                        <small class="text-muted">Minimal 8 karakter jika ingin mengubah</small>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="passwordConfirmDiv" style="display:none;">
                        <label class="form-label fw-600">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Ulangi password">
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Messages -->
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show position-fixed bottom-0 end-0 m-3" role="alert" style="z-index: 1000;">
    <i class="fas fa-exclamation-circle me-2"></i>
    <strong>Terjadi Kesalahan!</strong>
    <ul class="mb-0 mt-2 ps-4">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3 alert-animate" role="alert" style="z-index: 1000; animation: slideInUp 0.3s ease-out;">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show position-fixed bottom-0 end-0 m-3 alert-animate" role="alert" style="z-index: 1000; animation: slideInUp 0.3s ease-out;">
    <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<style>
    /* Fade in up animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes tableRowAnimate {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .table-row-animate {
        opacity: 0;
        animation: tableRowAnimate 0.5s ease-out forwards;
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-add {
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 11, 97, 0.3);
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 11, 97, 0.05);
        transform: translateX(5px);
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #0d0b61 0%, #1a1785 100%);
        color: white;
        border-radius: 15px 15px 0 0;
    }

    .modal-title {
        color: white !important;
    }

    .btn-close {
        filter: brightness(0) invert(1);
    }

    .fw-500 {
        font-weight: 500;
    }

    .fw-600 {
        font-weight: 600;
    }

    .alert-animate {
        animation: slideInUp 0.4s ease-out !important;
    }
</style>

<script>
    function editUser(id, name, email, role, nik) {
        const form = document.getElementById('editUserForm');
        form.action = `/admin/users/${id}/update`;
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('input[name="email"]').value = email;
        form.querySelector('select[name="role"]').value = role;
        form.querySelector('input[name="password"]').value = '';
        form.querySelector('input[name="password_confirmation"]').value = '';
        
        // Handle NIK field visibility
        const nikField = document.getElementById('nikFieldEdit');
        const nikSelect = document.getElementById('nikSelectEdit');
        if (role === 'karyawan') {
            nikField.style.display = 'block';
            nikSelect.value = nik || '';
        } else {
            nikField.style.display = 'none';
            nikSelect.value = '';
        }
        
        document.getElementById('passwordConfirmDiv').style.display = 'none';
    }

    function handleRoleChange(modalType) {
        const roleSelect = document.getElementById(modalType === 'add' ? 'addRoleSelect' : 'editRoleSelect');
        const nikField = document.getElementById(modalType === 'add' ? 'nikFieldAdd' : 'nikFieldEdit');
        
        if (roleSelect.value === 'karyawan') {
            nikField.style.display = 'block';
            nikField.querySelector('select').required = true;
        } else {
            nikField.style.display = 'none';
            nikField.querySelector('select').required = false;
            nikField.querySelector('select').value = '';
        }
    }

    // Show password confirmation field when password is entered
    document.getElementById('editUserForm').querySelector('input[name="password"]').addEventListener('input', function() {
        const confirmDiv = document.getElementById('passwordConfirmDiv');
        if (this.value.length > 0) {
            confirmDiv.style.display = 'block';
            confirmDiv.querySelector('input[name="password_confirmation"]').required = true;
        } else {
            confirmDiv.style.display = 'none';
            confirmDiv.querySelector('input[name="password_confirmation"]').required = false;
        }
    });

    // Reset form when modal is hidden
    document.getElementById('addUserModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('addUserForm').reset();
        document.getElementById('nikFieldAdd').style.display = 'none';
    });

    // Reset edit form
    document.getElementById('editUserModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('editUserForm').reset();
        document.getElementById('nikFieldEdit').style.display = 'none';
        document.getElementById('passwordConfirmDiv').style.display = 'none';
    });
</script>

@endsection
