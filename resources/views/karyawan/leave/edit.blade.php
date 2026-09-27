@extends('karyawan.layout')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h3 class="fw-bold mb-0">Edit Pengajuan Cuti</h3>
</div>

@if ($leave->status !== 'pending')
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Peringatan:</strong> Hanya cuti dengan status "Menunggu" yang dapat diubah.
    </div>
@endif

<div class="table-container">
    @if ($leave->status === 'pending')
        <form action="{{ route('karyawan.leave.update', $leave->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="leave_type" class="form-label fw-bold">Tipe Cuti <span class="text-danger">*</span></label>
                <select class="form-select @error('leave_type') is-invalid @enderror"
                        id="leave_type" name="leave_type" required onchange="updateLeaveBalance()">
                    <option value="">-- Pilih Tipe Cuti --</option>
                    <option value="annual" {{ old('leave_type', $leave->leave_type) === 'annual' ? 'selected' : '' }}>Cuti Tahunan</option>
                    <option value="sick" {{ old('leave_type', $leave->leave_type) === 'sick' ? 'selected' : '' }}>Cuti Sakit</option>
                    <option value="personal" {{ old('leave_type', $leave->leave_type) === 'personal' ? 'selected' : '' }}>Cuti Pribadi</option>
                    <option value="other" {{ old('leave_type', $leave->leave_type) === 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('leave_type')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                           id="start_date" name="start_date"
                           value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required
                           onchange="calculateDays()">
                    <small class="text-muted">Tanggal mulai cuti</small>
                    @error('start_date')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-bold">Tanggal Akhir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                           id="end_date" name="end_date"
                           value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required
                           onchange="calculateDays()">
                    <small class="text-muted">Tanggal akhir cuti</small>
                    @error('end_date')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card border-light">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Jumlah Hari</h6>
                            <h3 class="fw-bold text-primary mb-0" id="daysCount">{{ $leave->days_count }}</h3>
                            <small class="text-muted">hari kerja</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-light" id="leaveBalanceCard" style="{{ $leave->leave_type === 'annual' ? '' : 'display: none;' }}">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Sisa Cuti Tahunan</h6>
                            <h3 class="fw-bold text-success mb-0" id="leaveBalance">{{ $annualLeaveRemaining }}</h3>
                            <small class="text-muted">hari</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label fw-bold">Alasan Cuti <span class="text-danger">*</span></label>
                <textarea class="form-control @error('reason') is-invalid @enderror"
                          id="reason" name="reason" rows="3" required
                          placeholder="Jelaskan alasan pengajuan cuti Anda...">{{ old('reason', $leave->reason) }}</textarea>
                <small class="text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                @error('reason')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary">
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
            <strong>Tidak Dapat Diubah:</strong> Cuti dengan status "{{ ucfirst($leave->status) }}" tidak dapat diubah lagi.
        </div>
        <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    @endif
</div>

<!-- Load flatpickr for date picker enhancement (optional) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
// Annual leave balance
const annualLeaveRemaining = {{ $annualLeaveRemaining }};

function updateLeaveBalance() {
    const leaveType = document.getElementById('leave_type').value;
    const leaveBalanceCard = document.getElementById('leaveBalanceCard');

    if (leaveType === 'annual') {
        leaveBalanceCard.style.display = 'block';
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

@endsection
