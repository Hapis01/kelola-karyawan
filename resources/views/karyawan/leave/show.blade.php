@extends('karyawan.layout')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h3 class="fw-bold mb-0">Detail Pengajuan Cuti</h3>
</div>

<div class="table-container">
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
                                <td class="fw-bold" style="width: 30%;">Tipe Cuti</td>
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
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </span>
                                    @elseif($leave->status === 'approved')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Disetujui
                                        </span>
                                    @elseif($leave->status === 'rejected')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-ban me-1"></i>Dibatalkan
                                        </span>
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
                        <i class="fas fa-check-circle me-2"></i>Persetujuan Admin
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
            <div class="card border-light">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="fas fa-tasks text-primary me-2"></i>Aksi
                    </h5>

                    @if ($leave->status === 'pending')
                        <p class="text-muted small mb-3">Cuti Anda sedang menunggu persetujuan admin.</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('karyawan.leave.edit', $leave->id) }}"
                               class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm"
                                    onclick="cancelLeave()">
                                <i class="fas fa-ban me-2"></i>Batalkan
                            </button>
                        </div>
                    @elseif($leave->status === 'approved')
                        <p class="text-muted small mb-3">Cuti Anda telah disetujui. Anda dapat membatalkannya jika diperlukan.</p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-warning btn-sm"
                                    onclick="cancelLeave()">
                                <i class="fas fa-ban me-2"></i>Batalkan
                            </button>
                        </div>
                    @elseif($leave->status === 'rejected')
                        <p class="text-muted small mb-3">Cuti Anda telah ditolak. Silakan ajukan pengajuan baru.</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('karyawan.leave.create') }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Ajukan Cuti Baru
                            </a>
                        </div>
                    @else
                        <p class="text-muted small mb-3">Cuti ini telah dibatalkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('karyawan.leave.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Batalkan Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pengajuan cuti ini?</p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('karyawan.leave.cancel', $leave->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm text-dark">Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function cancelLeave() {
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}
</script>

@endsection
