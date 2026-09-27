@extends('karyawan.layout')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('karyawan.profile') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <h3 class="fw-bold mb-0">Riwayat Perubahan Profil</h3>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: slideDown 0.5s ease;">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-container">
    @if ($updates->count() > 0)
        <div class="timeline">
            @foreach ($updates as $update)
                <div class="timeline-item mb-4" style="animation: slideUp {{ 0.5 + (0.1 * $loop->index) }}s ease;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border-light shadow-sm" style="border-left: 4px solid
                                @if($update->status === 'pending')
                                    #ffc107
                                @elseif($update->status === 'approved')
                                    #28a745
                                @else
                                    #dc3545
                                @endif
                            ;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="fw-bold mb-0">
                                            <i class="fas fa-user-edit me-2 text-primary"></i>
                                            {{ ucfirst(str_replace('_', ' ', $update->field_name)) }}
                                        </h6>
                                        <span class="badge bg-{{ $update->status === 'pending' ? 'warning' : ($update->status === 'approved' ? 'success' : 'danger') }}">
                                            @if ($update->status === 'pending')
                                                <i class="fas fa-hourglass-half me-1"></i>Menunggu
                                            @elseif ($update->status === 'approved')
                                                <i class="fas fa-check-circle me-1"></i>Disetujui
                                            @else
                                                <i class="fas fa-times-circle me-1"></i>Ditolak
                                            @endif
                                        </span>
                                    </div>

                                    <p class="text-muted small mb-3 pb-3 border-bottom">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $update->created_at->format('d M Y H:i') }}
                                    </p>

                                    <div class="change-comparison p-3 bg-light rounded mb-3">
                                        <div class="mb-3">
                                            <p class="mb-2">
                                                <strong><i class="fas fa-times-circle text-danger me-2"></i>Nilai Lama:</strong>
                                            </p>
                                            <div style="padding: 0.75rem; background: #fff3cd; border-left: 3px solid #dc3545; border-radius: 0.25rem;">
                                                <code class="text-danger">{{ $update->old_value ?? '(kosong)' }}</code>
                                            </div>
                                        </div>
                                        <div class="text-center my-3">
                                            <i class="fas fa-arrow-down text-muted" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <p class="mb-2">
                                                <strong><i class="fas fa-check-circle text-success me-2"></i>Nilai Baru:</strong>
                                            </p>
                                            <div style="padding: 0.75rem; background: #d4edda; border-left: 3px solid #28a745; border-radius: 0.25rem;">
                                                <code class="text-success">{{ $update->new_value }}</code>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($update->status !== 'pending' && $update->admin_notes)
                                        <div class="alert alert-{{ $update->status === 'approved' ? 'success' : 'danger' }} mt-3 mb-0" role="alert">
                                            <h6 class="alert-heading mb-2 fw-bold">
                                                @if ($update->status === 'approved')
                                                    <i class="fas fa-thumbs-up me-2"></i>Catatan Persetujuan
                                                @else
                                                    <i class="fas fa-exclamation-circle me-2"></i>Alasan Penolakan
                                                @endif
                                            </h6>
                                            <p class="mb-0">{{ $update->admin_notes }}</p>
                                        </div>
                                    @endif

                                    @if ($update->status === 'pending')
                                        <div class="alert alert-info mt-3 mb-0" role="alert">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Sedang menunggu persetujuan admin. Anda dapat membatalkan perubahan ini.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if ($update->status === 'pending')
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-danger btn-sm fw-bold"
                                            onclick="cancelUpdate({{ $update->id }})" style="animation: slideUp 0.6s ease;">
                                        <i class="fas fa-ban me-2"></i>Batalkan Perubahan
                                    </button>
                                </div>
                            @else
                                <div class="card border-light bg-light" style="animation: slideUp 0.6s ease;">
                                    <div class="card-body">
                                        <p class="text-muted small mb-0">
                                            @if ($update->status === 'approved')
                                                <i class="fas fa-user-check text-success me-2"></i>
                                                <strong>Disetujui oleh:</strong><br>
                                                {{ $update->approvedBy->name ?? 'Admin' }}<br>
                                                <small>{{ $update->approved_at->format('d M Y H:i') }}</small>
                                            @else
                                                <i class="fas fa-user-slash text-danger me-2"></i>
                                                <strong>Ditolak oleh:</strong><br>
                                                {{ $update->approvedBy->name ?? 'Admin' }}<br>
                                                <small>{{ $update->approved_at->format('d M Y H:i') }}</small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
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
        <div class="text-center py-5" style="animation: fadeIn 0.6s ease;">
            <i class="fas fa-history text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada perubahan profil</p>
            <a href="{{ route('karyawan.profile.edit') }}" class="btn btn-primary btn-sm mt-2">
                <i class="fas fa-edit me-2"></i>Edit Profil
            </a>
        </div>
    @endif
</div>

<div class="mt-4">
    <a href="{{ route('karyawan.profile') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
    </a>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Batalkan Perubahan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Apakah Anda yakin ingin membatalkan perubahan ini?</p>
                <p class="text-muted small mb-0">
                    <i class="fas fa-info-circle me-1"></i>Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm fw-bold">
                        <i class="fas fa-trash me-1"></i>Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function cancelUpdate(updateId) {
    const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
    const cancelForm = document.getElementById('cancelForm');
    cancelForm.action = `/karyawan/profile-updates/${updateId}`;
    cancelModal.show();
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

    /* Timeline Styling */
    .timeline {
        position: relative;
    }

    .timeline-item {
        padding-left: 0;
        border-left: none;
        position: relative;
        transition: all 0.3s ease;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -20px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #10185f;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #10185f;
        transition: all 0.3s ease;
    }

    .timeline-item:hover::before {
        width: 16px;
        height: 16px;
        left: -24px;
        box-shadow: 0 0 0 4px #10185f;
    }

    /* Card Hover Effect */
    .card {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px);
    }

    /* Code Styling */
    code {
        font-family: 'Courier New', monospace;
        padding: 0.2rem 0.4rem;
        background: transparent;
    }

    /* Alert Animation */
    .alert {
        animation: slideDown 0.5s ease;
    }

    /* Button Styling */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .timeline-item {
            padding-left: 30px;
        }

        .timeline-item::before {
            left: -20px;
        }

        .timeline-item:hover::before {
            left: -20px;
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

        .col-md-4 {
            margin-top: 1rem;
        }
    }
</style>
@endpush

@endsection
