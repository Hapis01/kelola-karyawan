@extends('admin.layout')

@section('content')

<div class="profile-container">
    <!-- Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-custom" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Terjadi Kesalahan!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <ul class="mb-0 mt-2 ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Profile Information Form -->
        <div class="col-lg-6">
            <div class="card profile-card fade-in-up">
                <div class="card-header profile-card-header">
                    <div class="header-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Informasi Profil</h5>
                        <p class="text-muted small mb-0">Perbarui informasi pribadi Anda</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <table class="table profile-table mb-0">
                            <tbody>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <input type="text" name="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-envelope text-primary me-2"></i>Email Address
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <input type="email" name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-phone text-primary me-2"></i>Nomor Telepon
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <input type="text" name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               value="{{ old('phone', $user->phone ?? '') }}" 
                                               placeholder="Contoh: +62-812-3456-7890">
                                        @error('phone')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <textarea name="address" 
                                                  class="form-control @error('address') is-invalid @enderror" 
                                                  rows="3" 
                                                  placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address ?? '') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="action-cell">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="col-lg-6">
            <div class="card profile-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="card-header profile-card-header profile-card-header-danger">
                    <div class="header-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Ubah Password</h5>
                        <p class="text-muted small mb-0">Perbarui password akun Anda</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('admin.profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="alert alert-info border-0 m-4 mb-0" role="alert">
                            <i class="fas fa-shield-alt me-2"></i>
                            <small>Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol.</small>
                        </div>

                        <table class="table profile-table mb-0">
                            <tbody>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-key text-danger me-2"></i>Password Saat Ini
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <div class="input-group">
                                            <input type="password" name="current_password" 
                                                   class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="currentPassword" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-lock-open text-danger me-2"></i>Password Baru
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <div class="input-group">
                                            <input type="password" name="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="newPassword" placeholder="Minimal 8 karakter" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-check-circle text-danger me-2"></i>Konfirmasi Password
                                        </label>
                                    </td>
                                    <td class="input-cell">
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" 
                                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                   id="confirmPassword" placeholder="Ketik ulang password baru" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="action-cell">
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-check me-2"></i>Ubah Password
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Profile Card */
    .profile-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .profile-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .profile-card-header {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border: none;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .profile-card-header-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .header-icon {
        font-size: 32px;
        opacity: 0.8;
        min-width: 40px;
        text-align: center;
    }

    .profile-card-header h5 {
        font-weight: 700;
        margin: 0;
        color: white;
    }

    .profile-card-header p {
        color: rgba(255, 255, 255, 0.9);
    }

    /* Profile Table */
    .profile-table {
        margin: 0;
    }

    .profile-table tbody tr {
        border-bottom: 1px solid #ecf0f1;
    }

    .profile-table tbody tr:last-child {
        border-bottom: none;
    }

    .label-cell {
        width: 35%;
        padding: 20px 25px !important;
        background-color: #f8f9fa;
        vertical-align: middle;
    }

    .label-cell .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0;
        font-size: 14px;
    }

    .input-cell {
        padding: 20px 25px !important;
        vertical-align: middle;
    }

    .action-cell {
        padding: 25px !important;
        background-color: #f8f9fa;
    }

    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: white;
    }

    .form-control:focus {
        background-color: white;
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    }

    .form-control.is-invalid {
        border-color: #e74c3c;
    }

    .form-control.is-invalid:focus {
        border-color: #e74c3c;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
    }

    textarea.form-control {
        resize: vertical;
    }

    .input-group .form-control {
        border-right: none;
    }

    .input-group .btn-outline-secondary {
        border: 2px solid #e9ecef;
        border-left: none;
        color: #95a5a6;
        background-color: white;
        transition: all 0.3s ease;
    }

    .input-group .btn-outline-secondary:hover,
    .input-group .btn-outline-secondary:focus {
        background-color: white;
        border-color: #3498db;
        color: #3498db;
    }

    .input-group .form-control.is-invalid ~ .btn-outline-secondary {
        border-color: #e74c3c;
    }

    /* Buttons */
    .btn {
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        text-transform: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2980b9 0%, #2471a3 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        color: white;
    }

    /* Alert */
    .alert-custom {
        border: none;
        border-radius: 8px;
        margin-bottom: 30px;
        border-left: 4px solid;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left-color: #28a745 !important;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-left-color: #dc3545 !important;
    }

    .alert-info {
        background-color: #cfe2ff;
        color: #084298;
        border-left-color: #0d6efd !important;
    }

    .alert-info small {
        color: inherit;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .profile-card {
            margin-bottom: 20px;
        }

        .label-cell {
            width: 40%;
            padding: 15px 20px !important;
        }

        .input-cell {
            padding: 15px 20px !important;
        }

        .action-cell {
            padding: 20px !important;
        }

        .profile-card-header {
            padding: 20px;
        }

        .header-icon {
            font-size: 28px;
            min-width: 35px;
        }

        .profile-card-header h5 {
            font-size: 1.1rem;
        }

        .form-control {
            padding: 10px 12px;
            font-size: 13px;
        }

        .btn {
            padding: 10px 16px;
            font-size: 14px;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 15px;
        }

        .row.g-4 {
            gap: 1rem !important;
        }

        .profile-card {
            margin-bottom: 15px;
        }

        .profile-table tbody tr {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #ecf0f1;
        }

        .profile-table tbody tr:last-child {
            border-bottom: none;
        }

        .label-cell,
        .input-cell {
            display: block !important;
            width: 100% !important;
            padding: 12px 15px !important;
            border: none;
        }

        .label-cell {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .input-cell {
            background-color: white;
        }

        .action-cell {
            display: block !important;
            width: 100% !important;
            padding: 15px !important;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .profile-card-header {
            padding: 15px;
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }

        .header-icon {
            font-size: 24px;
            min-width: auto;
        }

        .profile-card-header h5 {
            font-size: 1rem;
        }

        .profile-card-header p {
            font-size: 0.85rem;
        }

        .alert-info {
            margin: 15px !important;
            padding: 12px 15px !important;
        }

        .form-control {
            padding: 8px 10px;
            font-size: 13px;
        }

        .form-label {
            font-size: 13px;
            margin-bottom: 8px;
        }

        .btn {
            padding: 8px 12px;
            font-size: 13px;
            width: 100%;
        }

        textarea.form-control {
            min-height: 80px;
        }

        .input-group {
            width: 100%;
        }

        .input-group .btn-outline-secondary {
            padding: 8px 10px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .profile-container {
            padding: 12px;
        }

        .profile-card {
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .label-cell {
            padding: 10px 12px !important;
        }

        .input-cell {
            padding: 10px 12px !important;
        }

        .action-cell {
            padding: 12px !important;
        }

        .profile-card-header {
            padding: 12px;
        }

        .header-icon {
            font-size: 20px;
        }

        .profile-card-header h5 {
            font-size: 0.95rem;
        }

        .profile-card-header p {
            font-size: 0.8rem;
        }

        .form-control {
            padding: 7px 10px;
            font-size: 12px;
        }

        .form-label {
            font-size: 12px;
        }

        .alert-info {
            font-size: 12px;
            padding: 10px 12px !important;
        }

        h3 {
            font-size: 1.1rem;
        }

        .btn {
            padding: 7px 10px;
            font-size: 12px;
        }
    }

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

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const btn = event.target.closest('button');
        const icon = btn.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Auto hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-custom');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endpush