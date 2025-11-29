@extends('admin.layout')

@section('content')

<h3 class="fw-bold mb-3">Preview Karyawan</h3>

@if(isset($karyawan))
    <div class="card">
        <div class="card-body">
            <h5>{{ $karyawan->nama }}</h5>
            <p><strong>NIK:</strong> {{ $karyawan->nik }}</p>
            <p><strong>Divisi:</strong> {{ $karyawan->divisi->nama ?? 'N/A' }}</p>
            <p><strong>Posisi:</strong> {{ $karyawan->posisi }}</p>
            <p><strong>Gaji:</strong> Rp {{ number_format($karyawan->gaji ?? 0, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ $karyawan->status }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $karyawan->jenis_kelamin }}</p>
            <p><strong>Alamat:</strong> {{ $karyawan->alamat }}</p>
            
            <hr>
            
            <p><strong>Keterangan:</strong></p>
            @if($karyawan->keterangan)
                <div class="alert alert-info">
                    <pre>{{ $karyawan->keterangan }}</pre>
                </div>
            @else
                <div class="alert alert-warning">
                    Tidak ada keterangan
                </div>
            @endif
            
            <hr>
            
            <p><strong>Histories:</strong></p>
            @if(count($histories) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $history->action }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada history</p>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-danger">Karyawan tidak ditemukan</div>
@endif

@endsection
