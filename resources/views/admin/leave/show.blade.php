@extends('admin.layout')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.leave.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
        <h3 class="fw-bold mb-0">Detail Cuti</h3>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="mb-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-calendar text-primary me-2"></i>Informasi Cuti
            </h5>

            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold" style="width: 30%;">Karyawan</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>
                                <strong>{{ $leave->karyawan->nama }}</strong><br>
                                <small class="text-muted">{{ $leave->nik }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tipe Cuti</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>
                                @switch($leave->leave_type)
                                    @case('annual')
                                        <span class="badge bg-info">Cuti Tahunan</span>
                                        @break
                                    @case('sick')
                                        <span class="badge bg-danger">Cuti Sakit</span>
                                        @break
                                    @case('personal')
                                        <span class="badge bg-warning text-dark">Cuti Pribadi</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($leave->leave_type) }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Mulai</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Akhir</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Hari</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td><strong class="text-primary">{{ $leave->days_count }} hari</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>
                                @if ($leave->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($leave->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($leave->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Pengajuan</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ $leave->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-align-left text-info me-2"></i>Alasan Cuti
            </h5>
            <p>{{ $leave->reason }}</p>
        </div>

        @if ($leave->status === 'rejected' && $leave->admin_notes)
            <div class="alert alert-danger mb-4" role="alert">
                <h6 class="alert-heading">
                    <i class="fas fa-times-circle me-2"></i>Alasan Penolakan
                </h6>
                {{ $leave->admin_notes }}
            </div>
        @elseif ($leave->status === 'approved')
            <div class="alert alert-success mb-4" role="alert">
                <h6 class="alert-heading">
                    <i class="fas fa-check-circle me-2"></i>Persetujuan
                </h6>
                <p class="mb-1">Disetujui oleh: <strong>{{ $leave->approvedBy->name ?? 'Admin' }}</strong></p>
                <p class="mb-0">Tanggal: {{ $leave->approved_at->format('d M Y H:i') }}</p>
                @if ($leave->admin_notes)
                    <p class="mb-0 mt-2">Catatan: {{ $leave->admin_notes }}</p>
                @endif
            </div>
        @endif
    </div>

    <div class="col-md-4">
        @if ($leave->status === 'pending')
            <div class="card border-light mb-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="fas fa-tasks text-primary me-2"></i>Aksi
                    </h5>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-sm" onclick="approveLeave()">
                            <i class="fas fa-check-circle me-2"></i>Setujui
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="rejectLeave()">
                            <i class="fas fa-times-circle me-2"></i>Tolak
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="card border-light">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">
                    <i class="fas fa-info-circle text-info me-2"></i>Informasi
                </h5>

                <p class="small text-muted mb-0">
                    <i class="fas fa-user me-2"></i>
                    <strong>Divisi:</strong> {{ $leave->karyawan->divisi->nama }}<br>
                    <strong>Posisi:</strong> {{ $leave->karyawan->posisi }}<br>
                    <strong>Status:</strong> {{ $leave->karyawan->status }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.leave.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Setujui Cuti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.leave.approve', $leave->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menyetujui cuti ini?</p>
                    <div class="mb-3">
                        <label for="approve_notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="approve_notes" name="admin_notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Cuti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.leave.reject', $leave->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menolak cuti ini?</p>
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_notes" name="admin_notes" rows="3" required></textarea>
                        <small class="text-muted">Minimal 10 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveLeave() {
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectLeave() {
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

@endsection
