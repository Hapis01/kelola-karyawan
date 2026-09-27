@extends('karyawan.layout')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h3 class="fw-bold mb-0">Edit Sertifikat</h3>
</div>

@if ($training->status !== 'pending')
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Peringatan:</strong> Hanya sertifikat dengan status "Menunggu" yang dapat diubah.
    </div>
@endif

<div class="table-container">
    @if ($training->status === 'pending')
        <form action="{{ route('karyawan.training.update', $training->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="training_name" class="form-label fw-bold">Nama Sertifikat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('training_name') is-invalid @enderror"
                       id="training_name" name="training_name" value="{{ old('training_name', $training->training_name) }}" required>
                @error('training_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="training_date" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('training_date') is-invalid @enderror"
                           id="training_date" name="training_date"
                           value="{{ old('training_date', $training->training_date->format('Y-m-d')) }}" required>
                    @error('training_date')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="training_provider" class="form-label fw-bold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('training_provider') is-invalid @enderror"
                           id="training_provider" name="training_provider"
                           value="{{ old('training_provider', $training->training_provider) }}" required>
                    @error('training_provider')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="certificate_file" class="form-label fw-bold">File Sertifikat (Opsional)</label>
                <p class="text-muted small mb-2">
                    <i class="fas fa-info-circle me-1"></i>
                    File saat ini: <strong>{{ basename($training->certificate_file) }}</strong>
                </p>
                <div class="form-control p-3 text-center border-2 border-dashed position-relative"
                     style="cursor: pointer; transition: all 0.3s;" id="dropZone">
                    <i class="fas fa-cloud-upload-alt text-primary" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-1 fw-bold">Drag & drop file baru di sini</p>
                    <p class="text-muted small">atau klik untuk memilih file</p>
                    <p class="text-muted small mt-2">Format: PDF, JPG, PNG (Max 5MB)</p>
                    <input type="file" id="certificate_file" name="certificate_file"
                           accept=".pdf,.jpg,.jpeg,.png" class="d-none">
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
                          placeholder="Deskripsi singkat tentang pelatihan...">{{ old('description', $training->description) }}</textarea>
                <small class="text-muted">Maksimal 1000 karakter</small>
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    @else
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-lock me-2"></i>
            <strong>Tidak Dapat Diubah:</strong> Pelatihan dengan status "{{ ucfirst($training->status) }}" tidak dapat diubah lagi.
        </div>
        <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    @endif
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
