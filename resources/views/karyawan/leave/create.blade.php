@extends('karyawan.layout')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
        <h3 class="fw-bold mb-0">Ajukan Cuti</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="animation: slideUp 0.5s ease;">
            <div class="card-header bg-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-calendar-alt me-2"></i>Form Pengajuan Cuti
                </h5>
            </div>

            <form action="{{ route('karyawan.leave.store') }}" method="POST" class="card-body">
                @csrf

                <!-- Tipe Cuti -->
                <div class="mb-4">
                    <label for="leave_type" class="form-label fw-bold">Tipe Cuti <span class="text-danger">*</span></label>
                    <select class="form-select @error('leave_type') is-invalid @enderror"
                            id="leave_type" name="leave_type" required onchange="updateLeaveBalance()">
                        <option value="">-- Pilih Tipe Cuti --</option>
                        <option value="annual" {{ old('leave_type') === 'annual' ? 'selected' : '' }}>
                            <i class="fas fa-calendar"></i> Cuti Tahunan
                        </option>
                        <option value="sick" {{ old('leave_type') === 'sick' ? 'selected' : '' }}>
                            <i class="fas fa-hospital"></i> Cuti Sakit
                        </option>
                        <option value="personal" {{ old('leave_type') === 'personal' ? 'selected' : '' }}>
                            <i class="fas fa-user"></i> Cuti Pribadi
                        </option>
                        <option value="other" {{ old('leave_type') === 'other' ? 'selected' : '' }}>
                            <i class="fas fa-tag"></i> Lainnya
                        </option>
                    </select>
                    @error('leave_type')
                        <div class="invalid-feedback d-block" style="animation: slideDown 0.3s ease;">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Tanggal Mulai & Akhir -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                               id="start_date" name="start_date" value="{{ old('start_date') }}" required
                               onchange="calculateDays()">
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>Tanggal mulai cuti Anda
                        </small>
                        @error('start_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label fw-bold">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                               id="end_date" name="end_date" value="{{ old('end_date') }}" required
                               onchange="calculateDays()">
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>Tanggal akhir cuti Anda
                        </small>
                        @error('end_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Statistik Hari & Sisa Cuti -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-light bg-light">
                            <div class="card-body text-center py-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-calendar-days me-1"></i>Jumlah Hari
                                </h6>
                                <h3 class="fw-bold text-primary mb-0" id="daysCount">0</h3>
                                <small class="text-muted">hari kerja</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-light bg-light" id="leaveBalanceCard" style="display: none;">
                            <div class="card-body text-center py-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-chart-pie me-1"></i>Sisa Cuti Tahunan
                                </h6>
                                <h3 class="fw-bold text-success mb-0" id="leaveBalance">12</h3>
                                <small class="text-muted">hari</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alasan Cuti -->
                <div class="mb-4">
                    <label for="reason" class="form-label fw-bold">Alasan Cuti <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('reason') is-invalid @enderror"
                              id="reason" name="reason" rows="4" required
                              placeholder="Jelaskan alasan pengajuan cuti Anda secara jelas dan detail...">{{ old('reason') }}</textarea>
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-info-circle me-1"></i>Minimal 10 karakter, maksimal 500 karakter
                    </small>
                    @error('reason')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Informasi Penting -->
                <div class="alert alert-info border-0" role="alert" style="animation: slideDown 0.5s ease;">
                    <h6 class="alert-heading mb-3 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Informasi Penting
                    </h6>
                    <ul class="mb-0 small">
                        <li class="mb-2">
                            <i class="fas fa-check me-2 text-info"></i>Cuti tahunan Anda dibatasi maksimal <strong>12 hari per tahun</strong>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check me-2 text-info"></i>Pengajuan cuti minimal <strong>3 hari kerja sebelumnya</strong>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check me-2 text-info"></i>Admin akan <strong>meninjau dan memberikan persetujuan</strong>
                        </li>
                        <li>
                            <i class="fas fa-check me-2 text-info"></i>Anda akan menerima <strong>notifikasi</strong> untuk setiap tindakan admin
                        </li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 pt-3">
                    <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary flex-grow-1">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-paper-plane me-2"></i>Ajukan Cuti
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-md-4">
        <!-- Leave Info Card -->
        <div class="card border-0 shadow-sm mb-3" style="animation: slideUp 0.6s ease;">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-question-circle text-primary me-2"></i>Tipe Cuti
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-calendar text-info me-2"></i>Cuti Tahunan
                    </h6>
                    <small class="text-muted d-block">Cuti regular yang diberikan setiap tahun</small>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-hospital text-danger me-2"></i>Cuti Sakit
                    </h6>
                    <small class="text-muted d-block">Saat Anda sedang sakit dan tidak bisa bekerja</small>
                </div>
                <div class="mb-3">
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-user text-warning me-2"></i>Cuti Pribadi
                    </h6>
                    <small class="text-muted d-block">Keperluan pribadi atau keluarga yang mendesak</small>
                </div>
                <div>
                    <h6 class="text-muted mb-1">
                        <i class="fas fa-tag text-secondary me-2"></i>Lainnya
                    </h6>
                    <small class="text-muted d-block">Tipe cuti lainnya yang tidak termasuk kategori di atas</small>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card border-0 shadow-sm" style="animation: slideUp 0.7s ease;">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-link text-primary me-2"></i>Tautan Cepat
                </h6>
            </div>
            <div class="card-body">
                <a href="{{ route('karyawan.leave.index') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                    <i class="fas fa-list me-1"></i>Riwayat Cuti
                </a>
                <a href="{{ route('karyawan.dashboard') }}" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="fas fa-home me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Load flatpickr for date picker enhancement -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
// Set min date to today
const today = new Date().toISOString().split('T')[0];
document.getElementById('start_date').min = today;
document.getElementById('end_date').min = today;

// Annual leave balance (from server: {{ $annualLeaveRemaining }})
const annualLeaveRemaining = {{ $annualLeaveRemaining }};

function updateLeaveBalance() {
    const leaveType = document.getElementById('leave_type').value;
    const leaveBalanceCard = document.getElementById('leaveBalanceCard');

    if (leaveType === 'annual') {
        leaveBalanceCard.style.display = 'block';
        leaveBalanceCard.style.animation = 'slideUp 0.3s ease';
        document.getElementById('leaveBalance').textContent = annualLeaveRemaining;
    } else {
        leaveBalanceCard.style.display = 'none';
    }
}

function calculateDays() {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);

    if (startDate && endDate && startDate <= endDate) {
        const diffTime = endDate - startDate;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end date
        document.getElementById('daysCount').textContent = diffDays;

        // Update end date min
        document.getElementById('end_date').min = document.getElementById('start_date').value;
    } else {
        document.getElementById('daysCount').textContent = '0';
    }
}

// Update date inputs to trigger validation
document.getElementById('start_date').addEventListener('change', function() {
    document.getElementById('end_date').min = this.value;
});
</script>

@push('styles')
<style>
    /* Slide Up Animation */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Slide Down Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Focus Effect */
    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        transition: all 0.3s ease;
    }

    /* Card Hover Effect */
    .card {
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }

    /* Alert Animation */
    .alert {
        animation: slideDown 0.5s ease;
    }

    /* Button Styling */
    .btn {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Invalid Feedback Animation */
    .invalid-feedback {
        animation: slideDown 0.3s ease;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .col-md-4 {
            margin-top: 1rem;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }
</style>
@endpush

@endsection
