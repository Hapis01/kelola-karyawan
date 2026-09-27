@extends('admin.layout')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.training.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
        <h3 class="fw-bold mb-0">Detail Sertifikat</h3>
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
                <i class="fas fa-book text-primary me-2"></i>Informasi Pelatihan
            </h5>

            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold" style="width: 30%;">Karyawan</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>
                                <strong>{{ $training->karyawan->nama }}</strong><br>
                                <small class="text-muted">{{ $training->nik }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Nama Pelatihan</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ $training->training_name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Pelatihan</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ \Carbon\Carbon::parse($training->training_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Penyelenggara</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ $training->training_provider }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status</td>
                            <td class="d-none d-md-table-cell">:</td>
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
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Upload</td>
                            <td class="d-none d-md-table-cell">:</td>
                            <td>{{ $training->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if ($training->description)
            <div class="mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                </h5>
                <p>{{ $training->description }}</p>
            </div>
        @endif

        @if ($training->status === 'rejected' && $training->admin_notes)
            <div class="alert alert-danger mb-4" role="alert">
                <h6 class="alert-heading">
                    <i class="fas fa-times-circle me-2"></i>Alasan Penolakan
                </h6>
                {{ $training->admin_notes }}
            </div>
        @elseif ($training->status === 'approved')
            <div class="alert alert-success mb-4" role="alert">
                <h6 class="alert-heading">
                    <i class="fas fa-check-circle me-2"></i>Persetujuan
                </h6>
                <p class="mb-1">Disetujui oleh: <strong>{{ $training->approvedBy->name ?? 'Admin' }}</strong></p>
                <p class="mb-0">Tanggal: {{ $training->approved_at->format('d M Y H:i') }}</p>
                @if ($training->admin_notes)
                    <p class="mb-0 mt-2">Catatan: {{ $training->admin_notes }}</p>
                @endif
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card border-light mb-3">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">
                    <i class="fas fa-file-pdf text-danger me-2"></i>Sertifikat
                </h5>

                <div class="text-center mb-3">
                    @if (str_ends_with($training->certificate_file, '.pdf'))
                        <div class="alert alert-light" role="alert">
                            <i class="fas fa-file-pdf text-danger" style="font-size: 3rem;"></i>
                            <p class="mt-2 small fw-bold">PDF File</p>
                        </div>
                    @else
                        <img src="{{ Storage::url($training->certificate_file) }}"
                             alt="Certificate" class="img-fluid rounded border" style="max-height: 300px;">
                    @endif
                </div>

                <p class="small text-muted mb-3">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ basename($training->certificate_file) }}
                </p>

                <div class="d-grid gap-2 mb-3">
                    <a href="{{ Storage::url($training->certificate_file) }}"
                       target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-download me-2"></i>Unduh
                    </a>
                </div>
            </div>
        </div>

        @if ($training->status === 'pending')
            <div class="card border-light">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="fas fa-tasks text-primary me-2"></i>Aksi
                    </h5>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-sm"
                                onclick="approveTraining()">
                            <i class="fas fa-check-circle me-2"></i>Setujui
                        </button>
                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="rejectTraining()">
                            <i class="fas fa-times-circle me-2"></i>Tolak
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.training.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Setujui Pelatihan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.training.approve', $training->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menyetujui pelatihan ini?</p>
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
                <h5 class="modal-title">Tolak Pelatihan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.training.reject', $training->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menolak pelatihan ini?</p>
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
function approveTraining() {
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectTraining() {
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

@endsection
