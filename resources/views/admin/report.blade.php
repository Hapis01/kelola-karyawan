@extends('admin.layout')

@section('content')

<h3 class="fw-bold mb-3">Cetak Laporan Karyawan</h3>
<p class="mb-4">Buat laporan detail karyawan dalam format PDF. Pilih karyawan yang ingin dicetak atau cetak semua laporan karyawan.</p>

<!-- Report Options Card -->
<div class="card filter-card mb-4">
    <div class="card-body">
        <form id="reportForm" action="{{ route('admin.report.generate') }}" method="POST">
            @csrf
            
            <!-- Type Report Selection -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="fw-bold mb-3">Tipe Laporan</label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="type_report" id="typeSelected" value="selected" checked>
                        <label class="btn btn-outline-primary" for="typeSelected">
                            <i class="fas fa-hand-pointer me-2"></i>Karyawan Terpilih
                        </label>

                        <input type="radio" class="btn-check" name="type_report" id="typeAll" value="all">
                        <label class="btn btn-outline-primary" for="typeAll">
                            <i class="fas fa-list me-2"></i>Semua Karyawan
                        </label>
                    </div>
                </div>
            </div>

            <!-- Karyawan Selection -->
            <div id="karyawanSelection" class="row">
                <div class="col-md-12">
                    <label class="fw-bold mb-3">Pilih Karyawan</label>
                    <div class="card bg-light">
                        <div class="card-body p-3">
                            <div class="row g-2" id="karyawanList">
                                @foreach($karyawans as $k)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check p-3 border rounded-2 hover-card">
                                        <input class="form-check-input karyawan-checkbox" 
                                               type="checkbox" 
                                               name="karyawan_ids[]" 
                                               value="{{ $k->id }}" 
                                               id="karyawan{{ $k->id }}">
                                        <label class="form-check-label w-100 cursor-pointer" for="karyawan{{ $k->id }}">
                                            <div class="d-flex align-items-center gap-2">
                                                @if($k->foto)
                                                    <img src="{{ asset('storage/karyawan/' . $k->foto) }}" 
                                                         alt="{{ $k->nama }}" 
                                                         class="rounded-circle" 
                                                         width="35" height="35" 
                                                         style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 35px; height: 35px; background-color: #007bff; color: white; font-weight: bold;">
                                                        {{ substr($k->nama, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $k->nama }}</div>
                                                    <small class="text-muted">{{ $k->divisi->nama ?? 'N/A' }} • {{ $k->posisi }}</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Dipilih: <span id="selectedCount">0</span> karyawan
                        </small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-md-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        <i class="fas fa-file-pdf me-2"></i>Cetak PDF
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .filter-card {
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
    }

    .hover-card {
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
    }

    .hover-card:hover {
        background-color: #f8f9fa !important;
        border-color: #007bff !important;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
    }

    .form-check-input {
        cursor: pointer;
        width: 1.25em;
        height: 1.25em;
        border-radius: 0.25em;
        border: 2px solid #dee2e6;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-group {
        gap: 0;
    }

    .btn-group .btn {
        border-radius: 6px 0 0 6px;
        flex: 1;
        font-weight: 600;
    }

    .btn-group .btn:last-child {
        border-radius: 0 6px 6px 0;
    }

    .btn-group .btn:not(:last-child) {
        margin-right: 8px;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 6px;
    }

    .form-check-label {
        margin-bottom: 0;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            border-radius: 6px;
            width: 100%;
        }

        .btn-group .btn:not(:last-child) {
            margin-right: 0;
            margin-bottom: 8px;
        }

        .btn-group .btn:last-child {
            border-radius: 6px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelectedRadio = document.getElementById('typeSelected');
        const typeAllRadio = document.getElementById('typeAll');
        const karyawanSelection = document.getElementById('karyawanSelection');
        const karyawanCheckboxes = document.querySelectorAll('.karyawan-checkbox');
        const selectedCountSpan = document.getElementById('selectedCount');
        const reportForm = document.getElementById('reportForm');

        // Toggle karyawan selection visibility
        function toggleKaryawanSelection() {
            if (typeAllRadio.checked) {
                karyawanSelection.style.display = 'none';
                // Uncheck all
                karyawanCheckboxes.forEach(cb => cb.checked = false);
                updateSelectedCount();
            } else {
                karyawanSelection.style.display = 'block';
            }
        }

        typeSelectedRadio.addEventListener('change', toggleKaryawanSelection);
        typeAllRadio.addEventListener('change', toggleKaryawanSelection);

        // Update selected count
        function updateSelectedCount() {
            const count = Array.from(karyawanCheckboxes).filter(cb => cb.checked).length;
            selectedCountSpan.textContent = count;
        }

        karyawanCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });

        // Form validation
        reportForm.addEventListener('submit', function(e) {
            if (typeSelectedRadio.checked) {
                const checkedCount = Array.from(karyawanCheckboxes).filter(cb => cb.checked).length;
                if (checkedCount === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu karyawan untuk dicetak');
                    return false;
                }
            }
        });
    });
</script>
@endpush
