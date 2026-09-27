@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Manajemen Perubahan Profil</h3>
    <div class="badge bg-info">Total: {{ $updates->total() }}</div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.profile-updates.index') }}" class="row g-2">
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="nik" class="form-control form-control-sm"
                   placeholder="NIK/Nama..." value="{{ request('nik') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-search me-1"></i>Filter
            </button>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.profile-updates.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-redo me-1"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Updates List -->
<div class="table-container">
    @if ($updates->count() > 0)
        <div class="timeline">
            @foreach ($updates as $update)
                <div class="timeline-item mb-4 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">
                                        <strong>{{ $update->karyawan->nama }}</strong> ({{ $update->nik }})
                                    </h6>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-edit me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $update->field_name)) }}
                                    </p>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $update->created_at->format('d M Y H:i') }}
                                    </p>

                                    <div class="change-box p-2 bg-light rounded small">
                                        <div class="mb-2">
                                            <strong>Nilai Lama:</strong><br>
                                            <span class="text-danger">{{ $update->old_value ?? '(kosong)' }}</span>
                                        </div>
                                        <div class="text-center my-1">
                                            <i class="fas fa-arrow-right text-muted"></i>
                                        </div>
                                        <div>
                                            <strong>Nilai Baru:</strong><br>
                                            <span class="text-success">{{ $update->new_value }}</span>
                                        </div>
                                    </div>

                                    @if ($update->status !== 'pending' && $update->admin_notes)
                                        <div class="alert alert-{{ $update->status === 'approved' ? 'success' : 'danger' }} mt-2 mb-0 small" role="alert">
                                            <strong>
                                                @if ($update->status === 'approved')
                                                    ✓ Catatan Persetujuan
                                                @else
                                                    ✗ Alasan Penolakan
                                                @endif
                                            </strong><br>
                                            {{ $update->admin_notes }}
                                        </div>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $update->status === 'pending' ? 'warning' : ($update->status === 'approved' ? 'success' : 'danger') }} text-white">
                                    @if ($update->status === 'pending')
                                        Menunggu
                                    @elseif ($update->status === 'approved')
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if ($update->status === 'pending')
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="approveUpdate({{ $update->id }})">
                                        <i class="fas fa-check me-1"></i>Setujui
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="rejectUpdate({{ $update->id }})">
                                        <i class="fas fa-times me-1"></i>Tolak
                                    </button>
                                </div>
                            @else
                                <p class="text-muted small text-center">
                                    @if ($update->status === 'approved')
                                        <i class="fas fa-check-circle text-success"></i><br>
                                        Disetujui oleh<br>
                                        <strong>{{ $update->approvedBy->name ?? 'Admin' }}</strong><br>
                                        {{ $update->approved_at->format('d M Y') }}
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i><br>
                                        Ditolak oleh<br>
                                        <strong>{{ $update->approvedBy->name ?? 'Admin' }}</strong><br>
                                        {{ $update->approved_at->format('d M Y') }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $updates->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-check-circle text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada perubahan profil untuk ditinjau</p>
        </div>
    @endif
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Setujui Perubahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menyetujui perubahan profil ini?</p>
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
                <h5 class="modal-title">Tolak Perubahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menolak perubahan ini?</p>
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
function approveUpdate(updateId) {
    document.getElementById('approveForm').action = `/admin/profile-updates/${updateId}/approve`;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectUpdate(updateId) {
    document.getElementById('rejectForm').action = `/admin/profile-updates/${updateId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

<style>
.timeline-item {
    border-left: 4px solid #10185f;
    background-color: #f9f9f9;
}

.change-box {
    border-left: 3px solid #10185f;
}
</style>

@endsection
