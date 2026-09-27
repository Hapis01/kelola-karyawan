@extends('admin.layout')

@section('content')

<div class="page-header mb-4">
    <div class="row align-items-center g-2">
        <div class="col">
            <h3 class="fw-bold mb-0">Manajemen Sertifikat</h3>
        </div>
        <div class="col-auto">
            <div class="badge bg-info">Total: {{ $trainings->total() }}</div>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.training.index') }}" class="row g-2">
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
                   placeholder="Cari NIK/Nama..." value="{{ request('nik') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-search me-1"></i>Filter
            </button>
        </div>
        <div class="col-md-4">
            <div class="btn-group w-100 btn-group-sm" role="group">
                <a href="{{ route('admin.training.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-1"></i>Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <!-- Menunggu Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-warning" style="animation: slideUp 0.5s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Menunggu Persetujuan</div>
                <div class="stat-card-value">{{ $pending_count }}</div>
            </div>
        </div>
    </div>

    <!-- Disetujui Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-success" style="animation: slideUp 0.6s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Disetujui</div>
                <div class="stat-card-value">{{ $approved_count }}</div>
            </div>
        </div>
    </div>

    <!-- Ditolak Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-danger" style="animation: slideUp 0.7s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Ditolak</div>
                <div class="stat-card-value">{{ $rejected_count }}</div>
            </div>
        </div>
    </div>

    <!-- Total Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-primary" style="animation: slideUp 0.8s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Sertifikat</div>
                <div class="stat-card-value">{{ $trainings->total() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Training List -->
<div class="table-container">
    @if ($trainings->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Sertifikat</th>
                        <th>Tanggal</th>
                        <th>Penerbit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainings as $training)
                        <tr class="align-middle">
                            <td class="fw-bold">{{ $training->nik }}</td>
                            <td>{{ $training->karyawan->nama }}</td>
                            <td>{{ Str::limit($training->training_name, 30) }}</td>
                            <td>{{ \Carbon\Carbon::parse($training->training_date)->format('d M Y') }}</td>
                            <td>{{ Str::limit($training->training_provider, 25) }}</td>
                            <td>
                                @if ($training->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($training->status === 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.training.show', $training->id) }}"
                                       class="btn btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($training->status === 'pending')
                                        <button type="button" class="btn btn-outline-success"
                                                onclick="approveTraining({{ $training->id }})" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger"
                                                onclick="rejectTraining({{ $training->id }})" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-danger disabled"
                                                title="Hapus" onclick="deleteTraining({{ $training->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $trainings->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada sertifikat</p>
        </div>
    @endif
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Setujui Sertifikat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menyetujui sertifikat ini?</p>
                    <div class="mb-3">
                        <label for="approve_notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="approve_notes" name="admin_notes" rows="2"
                                  placeholder="Tambahkan catatan untuk karyawan..."></textarea>
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
                <h5 class="modal-title">Tolak Sertifikat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menolak sertifikat ini?</p>
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_notes" name="admin_notes" rows="3"
                                  placeholder="Jelaskan alasan penolakan..." required></textarea>
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
function approveTraining(trainingId) {
    const approveForm = document.getElementById('approveForm');
    approveForm.action = `/admin/training/${trainingId}/approve`;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectTraining(trainingId) {
    const rejectForm = document.getElementById('rejectForm');
    rejectForm.action = `/admin/training/${trainingId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function deleteTraining(trainingId) {
    if (confirm('Apakah Anda ingin menghapus sertifikat ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/training/${trainingId}`;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(token);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection
