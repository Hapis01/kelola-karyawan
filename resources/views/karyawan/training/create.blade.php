@extends('karyawan.layout')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
        <h3 class="fw-bold mb-0">Tambah Sertifikat</h3>
    </div>
</div>

<div class="table-container">
    <form action="{{ route('karyawan.training.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="training_name" class="form-label fw-bold">Nama Sertifikat <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('training_name') is-invalid @enderror"
                   id="training_name" name="training_name" value="{{ old('training_name') }}" required>
            @error('training_name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="training_date" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('training_date') is-invalid @enderror"
                       id="training_date" name="training_date" value="{{ old('training_date') }}" required>
                @error('training_date')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="training_provider" class="form-label fw-bold">Penerbit <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('training_provider') is-invalid @enderror"
                       id="training_provider" name="training_provider" value="{{ old('training_provider') }}" required>
                @error('training_provider')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="certificate_file" class="form-label fw-bold">File Sertifikat <span class="text-danger">*</span></label>
            <div class="form-control p-3 text-center border-2 border-dashed position-relative"
                 style="cursor: pointer; transition: all 0.3s;" id="dropZone">
                <i class="fas fa-cloud-upload-alt text-primary" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-1 fw-bold">Drag & drop file di sini</p>
                <p class="text-muted small">atau klik untuk memilih file</p>
                <p class="text-muted small mt-2">Format: PDF, JPG, PNG (Max 5MB)</p>
                <input type="file" id="certificate_file" name="certificate_file"
                       accept=".pdf,.jpg,.jpeg,.png" class="d-none" required>
            </div>
            <div id="fileName" class="mt-2 text-success small fw-bold" style="display: none;">
                <i class="fas fa-check-circle me-1"></i><span id="fileNameText"></span>
            </div>
            @error('certificate_file')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Deskripsi (Opsional)</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      id="description" name="description" rows="3"
                      placeholder="Deskripsi singkat tentang pelatihan...">{{ old('description') }}</textarea>
            <small class="text-muted">Maksimal 1000 karakter</small>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Informasi:</strong> Sertifikat pelatihan Anda akan dikirim ke admin untuk diverifikasi.
            Anda akan menerima notifikasi setelah disetujui atau ditolak.
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Upload Sertifikat
            </button>
        </div>
    </form>
</div>

<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('certificate_file');
const fileNameDiv = document.getElementById('fileName');
const fileNameText = document.getElementById('fileNameText');

// Click to select file
dropZone.addEventListener('click', () => fileInput.click());

// Drag and drop
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '#e3f2fd';
    dropZone.style.borderColor = '#2196f3';
});

dropZone.addEventListener('dragleave', () => {
    dropZone.style.backgroundColor = '';
    dropZone.style.borderColor = '';
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '';
    dropZone.style.borderColor = '';

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        updateFileName();
    }
});

// File change
fileInput.addEventListener('change', updateFileName);

function updateFileName() {
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        fileNameText.textContent = fileName;
        fileNameDiv.style.display = 'block';
    } else {
        fileNameDiv.style.display = 'none';
    }
}
</script>

@endsection
