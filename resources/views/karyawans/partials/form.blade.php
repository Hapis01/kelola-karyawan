<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $data->nama ?? '' }}" required>
    @error('nama')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>NIK</label>
    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ $data->nik ?? '' }}" required>
    @error('nik')
        <div class="invalid-feedback d-block">{!! $message !!}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Foto Profil</label>
    <div class="input-group">
        <input type="file" name="foto" class="form-control" accept="image/*" id="fotoInput">
        <small class="form-text text-muted d-block mt-2">Format: JPG, PNG, GIF (Max 5MB)</small>
    </div>
    @if(isset($data) && $data->foto)
        <div class="mt-2">
            <img src="{{ asset('storage/karyawan/' . $data->foto) }}" alt="Foto" style="max-width: 100px; max-height: 100px; margin-top: 5px;"
                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($data->nama ?? 'User') }}&background=007bff&color=ffffff&size=100';">
        </div>
    @endif
</div>

<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control">{{ $data->alamat ?? '' }}</textarea>
</div>

<div class="mb-3">
    <label>No. Telepon</label>
    <input type="text" name="no_telepon" class="form-control" value="{{ $data->no_telepon ?? '' }}" placeholder="08xxxxxxxxxx">
</div>

<div class="mb-3">
    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
        <option value="" disabled {{ !isset($data) ? 'selected' : '' }}>-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki" {{ (isset($data) && $data->jenis_kelamin=='Laki-laki')?'selected':'' }}>Laki-laki</option>
        <option value="Perempuan" {{ (isset($data) && $data->jenis_kelamin=='Perempuan')?'selected':'' }}>Perempuan</option>
    </select>
    @error('jenis_kelamin')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $data->tanggal_lahir ?? '' }}">
</div>

<div class="mb-3">
    <label>Tempat Lahir</label>
    <input type="text" name="tempat_lahir" class="form-control" value="{{ $data->tempat_lahir ?? '' }}" placeholder="Kota/Kabupaten">
</div>

<div class="mb-3">
    <label>Pendidikan Terakhir</label>
    <select name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror">
        <option value="">-- Pilih Pendidikan --</option>
        <option value="SMA" {{ (isset($data) && $data->pendidikan=='SMA')?'selected':'' }}>SMA</option>
        <option value="D3" {{ (isset($data) && $data->pendidikan=='D3')?'selected':'' }}>D3</option>
        <option value="S1" {{ (isset($data) && $data->pendidikan=='S1')?'selected':'' }}>S1</option>
        <option value="S2" {{ (isset($data) && $data->pendidikan=='S2')?'selected':'' }}>S2</option>
        <option value="S3" {{ (isset($data) && $data->pendidikan=='S3')?'selected':'' }}>S3</option>
    </select>
    @error('pendidikan')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Jurusan / Program Studi</label>
    <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ $data->jurusan ?? '' }}" placeholder="Contoh: Teknik Informatika, Manajemen Bisnis">
    @error('jurusan')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Divisi</label>
    <select name="divisi_id" class="form-control @error('divisi_id') is-invalid @enderror" required>
        <option value="">-- Pilih Divisi --</option>
        @foreach($divisis as $div)
            <option value="{{ $div->id }}" {{ (isset($data) && $data->divisi_id == $div->id) ? 'selected' : '' }}>
                {{ $div->nama }}
            </option>
        @endforeach
    </select>
    @error('divisi_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Posisi</label>
    <input type="text" name="posisi" class="form-control @error('posisi') is-invalid @enderror" value="{{ $data->posisi ?? '' }}" required>
    @error('posisi')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Gaji</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" name="gaji" class="form-control @error('gaji') is-invalid @enderror" value="{{ $data->gaji ?? '' }}" placeholder="Masukkan gaji">
    </div>
    <small class="form-text text-muted d-block mt-1">Gaji dalam Rupiah (contoh: 5000000 untuk Rp 5.000.000)</small>
    @error('gaji')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="Aktif" {{ (isset($data) && $data->status=='Aktif')?'selected':'' }}>Aktif</option>
        <option value="Tidak Aktif" {{ (isset($data) && $data->status=='Tidak Aktif')?'selected':'' }}>Tidak Aktif</option>
    </select>
    @error('status')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control">{{ $data->keterangan ?? '' }}</textarea>
</div>
