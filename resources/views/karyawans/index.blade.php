a@extends('layouts.app')

@section('content')

<h2 class="fw-bold">Data Karyawan</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Karyawan
</button>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Divisi</th>
            <th>Posisi</th>
            <th>Status</th>
            <th width="180px">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($karyawan as $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->nama }}</td>
            <td>{{ $k->nik }}</td>
            <td>{{ $k->alamat }}</td>
            <td>{{ $k->jenis_kelamin }}</td>
            <td>{{ $k->divisi }}</td>
            <td>{{ $k->posisi }}</td>
            <td>{{ $k->status }}</td>

            <td>
                <button class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal{{ $k->id }}">
                    Edit
                </button>

                <button class="btn btn-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal{{ $k->id }}">
                    Hapus
                </button>
            </td>
        </tr>

        {{-- EDIT MODAL --}}
        <div class="modal fade" id="editModal{{ $k->id }}">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('karyawans.update', $k->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            @include('karyawans.partials.form', ['data' => $k])
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- DELETE MODAL --}}
        <div class="modal fade" id="deleteModal{{ $k->id }}">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('karyawans.destroy', $k->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5>Hapus Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            Yakin ingin menghapus <b>{{ $k->nama }}</b>?
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-danger">Hapus</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        @endforeach
    </tbody>
</table>


{{-- PAGINATION --}}
{{ $karyawan->links() }}


{{-- ADD MODAL --}}
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('karyawans.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @include('karyawans.partials.form')
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
