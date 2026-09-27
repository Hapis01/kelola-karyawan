@extends('karyawan.layout')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h3 class="fw-bold mb-0">Detail Sertifikat</h3>
</div>

<div class="table-container">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-certificate text-primary me-2"></i>Informasi Sertifikat
                </h5>

                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold" style="width: 30%;">Nama Sertifikat</td>
                                <td class="d-none d-md-table-cell">:</td>
                                <td>{{ $training->training_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tanggal</td>
                                <td class="d-none d-md-table-cell">:</td>
                                <td>{{ \Carbon\Carbon::parse($training->training_date)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Penerbit</td>
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
                        <i class="fas fa-check-circle me-2"></i>Persetujuan Admin
                    </h6>
                    <p class="mb-1">Disetujui oleh: <strong>{{ $training->approvedBy->name ?? 'Admin' }}</strong></p>
                    <p class="mb-0">Tanggal: {{ $training->approved_at->format('d M Y H:i') }}</p>
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
                        Nama File: <strong>{{ basename($training->certificate_file) }}</strong>
                    </p>

                    <div class="d-grid gap-2">
                        <a href="{{ Storage::url($training->certificate_file) }}"
                           target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-download me-2"></i>Unduh Sertifikat
                        </a>
                        @if ($training->status === 'pending')
                            <a href="{{ route('karyawan.training.edit', $training->id) }}"
                               class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('karyawan.training.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

@endsection
