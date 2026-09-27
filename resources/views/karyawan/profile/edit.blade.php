@extends('karyawan.layout')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('karyawan.profile') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
        <h3 class="fw-bold mb-0">Edit Profil Saya</h3>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: slideInDown 0.5s ease;">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="animation: slideInDown 0.5s ease;">
        <i class="fas fa-exclamation-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card border-light shadow-sm mb-4" style="animation: fadeIn 0.5s ease;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 card-title">
                    <i class="fas fa-user-edit text-primary me-2"></i>Informasi Pribadi
                </h5>

                <form action="{{ route('karyawan.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    <!-- Foto Profil -->
                    <div class="mb-4 pb-3 border-bottom">
                        <label class="form-label fw-bold">Foto Profil</label>
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="profile-photo-preview" style="position: relative; display: inline-block;">
                                    <img id="photoPreview"
                                         src="{{ $karyawan->foto ? asset('storage/karyawan/' . $karyawan->foto) : asset('assets/images/default-avatar.png') }}"
                                         alt="Foto Profil"
                                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #10185f;">
                                    <label for="foto" style="position: absolute; bottom: 5px; right: 5px; cursor: pointer; background: #10185f; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                                        <i class="fas fa-camera" style="font-size: 0.9rem;"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                       id="foto" name="foto" accept="image/*" style="display: none;">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                       id="fotoInput" name="foto" accept="image/*">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format: JPG, PNG (Maks 2MB). Klik ikon kamera untuk mengganti.
                                </small>
                                @error('foto')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama', $karyawan->nama) }}" maxlength="255" required>
                            @error('nama')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="no_telepon" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror"
                                   id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $karyawan->no_telepon) }}" maxlength="20">
                            @error('no_telepon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                  id="alamat" name="alamat" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                   id="tanggal_lahir" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                   id="tempat_lahir" name="tempat_lahir"
                                   value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}" maxlength="100">
                            @error('tempat_lahir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pendidikan" class="form-label fw-bold">Pendidikan Terakhir</label>
                            <select class="form-select @error('pendidikan') is-invalid @enderror"
                                    id="pendidikan" name="pendidikan">
                                <option value="">-- Pilih --</option>
                                <option value="SMA" {{ old('pendidikan', $karyawan->pendidikan) === 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D3" {{ old('pendidikan', $karyawan->pendidikan) === 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('pendidikan', $karyawan->pendidikan) === 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan', $karyawan->pendidikan) === 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan', $karyawan->pendidikan) === 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="jurusan" class="form-label fw-bold">Jurusan / Program Studi</label>
                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror"
                               id="jurusan" name="jurusan"
                               value="{{ old('jurusan', $karyawan->jurusan) }}"
                               placeholder="Contoh: Teknik Informatika, Manajemen Bisnis, dll"
                               maxlength="255">
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>Isi dengan jurusan/program studi dari pendidikan terakhir Anda
                        </small>
                        @error('jurusan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert" style="background: linear-gradient(135deg, #e7f3ff 0%, #f0f8ff 100%); border: 1px solid #b3d9ff;">
                        <i class="fas fa-info-circle me-2" style="color: #0066cc;"></i>
                        <strong style="color: #0066cc;">Informasi Penting:</strong>
                        <p class="mb-0 mt-2" style="color: #333;">
                            Perubahan data profil Anda akan dikirim ke admin untuk diverifikasi sebelum diterapkan.
                            Anda akan menerima notifikasi ketika perubahan telah disetujui atau ditolak.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 justify-content-between">
                        <a href="{{ route('karyawan.profile') }}" class="btn btn-outline-secondary" style="transition: all 0.3s ease;">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                        </a>
                        <button type="submit" class="btn btn-primary" style="transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(16, 24, 95, 0.3);">
                            <i class="fas fa-check me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-md-4">
        <!-- Data Pekerjaan -->
        <div class="card border-light shadow-sm mb-3" style="animation: fadeIn 0.6s ease;">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">
                    <i class="fas fa-briefcase text-primary me-2"></i>Data Pekerjaan
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><small><strong>NIK:</strong></small><br><small class="text-muted">{{ $karyawan->nik }}</small></li>
                    <li class="mb-2"><small><strong>Posisi:</strong></small><br><small class="text-muted">{{ $karyawan->posisi }}</small></li>
                    <li class="mb-2"><small><strong>Divisi:</strong></small><br><small class="text-muted">{{ $karyawan->divisi->nama ?? 'N/A' }}</small></li>
                    <li class="mb-0"><small><strong>Status:</strong></small><br><span class="badge {{ $karyawan->status === 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $karyawan->status }}</span></li>
                </ul>
            </div>
        </div>

        <!-- Riwayat Perubahan -->
        <div class="card border-light shadow-sm mb-3" style="animation: fadeIn 0.7s ease;">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">
                    <i class="fas fa-history text-info me-2"></i>Riwayat Perubahan
                </h6>

                <p class="text-muted small mb-3">Lihat semua perubahan profil yang telah Anda ajukan dan status persetujuannya.</p>

                <a href="{{ route('karyawan.profile.history') }}" class="btn btn-info btn-sm w-100" style="transition: all 0.3s ease;">
                    <i class="fas fa-eye me-2"></i>Lihat Riwayat Lengkap
                </a>
            </div>
        </div>

        <!-- Informasi -->
        <div class="alert alert-warning small" role="alert" style="animation: fadeIn 0.8s ease;">
            <h6 class="alert-heading mb-2">
                <i class="fas fa-lock me-2"></i>Data Terlindungi
            </h6>
            <ul class="mb-0 small">
                <li class="mb-1">✓ Gaji tidak dapat diubah</li>
                <li class="mb-1">✓ Posisi tidak dapat diubah</li>
                <li class="mb-1">✓ NIK tidak dapat diubah</li>
                <li>✓ Hubungi admin untuk perubahan lain</li>
            </ul>
        </div>
    </div>
</div>

<!-- Custom Styles -->
@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-control:focus, .form-select:focus {
        border-color: #10185f;
        box-shadow: 0 0 0 0.2rem rgba(16, 24, 95, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 24, 95, 0.4);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }

    #photoPreview {
        transition: all 0.3s ease;
    }

    #photoPreview:hover {
        filter: brightness(0.95);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush

<!-- Photo Upload Handler -->
@push('scripts')
<script>
    const fotoInput = document.getElementById('fotoInput');
    const photoPreview = document.getElementById('photoPreview');

    // Handle file input change
    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                photoPreview.src = event.target.result;
                photoPreview.style.animation = 'fadeIn 0.5s ease';
            };
            reader.readAsDataURL(file);
        }
    });

    // Make camera icon clickable
    document.querySelector('[for="foto"]').addEventListener('click', function(e) {
        e.preventDefault();
        fotoInput.click();
    });
</script>
@endpush

@endsection
