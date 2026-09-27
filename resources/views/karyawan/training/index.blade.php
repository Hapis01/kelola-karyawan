@extends('karyawan.layout')

@section('content')

<div class="page-header mb-4">
    <div class="row align-items-center g-2">
        <div class="col">
            <h3 class="fw-bold mb-0">Sertifikat Saya</h3>
        </div>
        <div class="col-auto">
            <a href="{{ route('karyawan.training.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i><span class="d-none d-sm-inline">Tambah Sertifikat</span><span class="d-sm-none">Tambah</span>
            </a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: slideDown 0.5s ease;">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="animation: slideDown 0.5s ease;">
        <i class="fas fa-times-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="table-container mb-4" style="animation: slideUp 0.5s ease;">
    <form method="GET" action="{{ route('karyawan.training.index') }}" class="row g-2">
        <div class="col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-light">
                    <i class="fas fa-search text-muted"></i>
                </span>
            <input type="text" name="search" class="form-control border-light"
                   placeholder="Cari nama sertifikat..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-search me-1"></i>Cari
            </button>
        </div>
    </form>
</div>

<!-- Training List -->
<div class="table-container">
    @if ($trainings->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>
                            <i class="fas fa-certificate me-2 text-primary"></i>Nama Sertifikat
                        </th>
                        <th>
                            <i class="fas fa-calendar me-2 text-primary"></i>Tanggal
                        </th>
                        <th>
                            <i class="fas fa-building me-2 text-primary"></i>Penerbit
                        </th>
                        <th>
                            <i class="fas fa-tag me-2 text-primary"></i>Status
                        </th>
                        <th>
                            <i class="fas fa-cog me-2 text-primary"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainings as $training)
                        <tr class="align-middle" style="animation: fadeIn 0.5s ease;">
                            <td class="fw-bold">
                                <i class="fas fa-certificate text-warning me-2"></i>{{ $training->training_name }}
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($training->training_date)->format('d M Y') }}
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $training->training_provider }}</small>
                            </td>
                            <td>
                                @if ($training->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-hourglass-half me-1"></i>Menunggu
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
                                    <a href="{{ route('karyawan.training.show', $training->id) }}"
                                       class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($training->status === 'pending')
                                        <a href="{{ route('karyawan.training.edit', $training->id) }}"
                                           class="btn btn-outline-secondary btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="deleteTraining({{ $training->id }})" title="Hapus">
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
        <div class="text-center py-5" style="animation: fadeIn 0.6s ease;">
            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada sertifikat</p>
            <a href="{{ route('karyawan.training.create') }}" class="btn btn-primary btn-sm mt-2">
                <i class="fas fa-plus me-2"></i>Tambah Sertifikat
            </a>
        </div>
    @endif
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-trash-alt me-2"></i>Hapus Sertifikat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Apakah Anda yakin ingin menghapus sertifikat ini?</p>
                <p class="text-muted small mb-0">
                    <i class="fas fa-exclamation-triangle me-1"></i>Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm fw-bold">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteTraining(trainingId) {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/karyawan/training/${trainingId}`;
    deleteModal.show();
}
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
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Fade In Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Table Row Hover Effect */
    .table tbody tr {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Button Hover Effects */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Input Group Focus */
    .input-group:focus-within {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-radius: 0.375rem;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
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

        .btn-group-sm {
            width: 100%;
        }
    }
</style>
@endpush

@endsection
