<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ $data->nama ?? '' }}" required>
</div>

<div class="mb-3">
    <label>NIK</label>
    <input type="text" name="nik" class="form-control" value="{{ $data->nik ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Foto Profil</label>
    <div class="input-group">
        <input type="file" name="foto" class="form-control" accept="image/*" id="fotoInput">
        <small class="form-text text-muted d-block mt-2">Format: JPG, PNG, GIF (Max 5MB)</small>
    </div>
    @if(isset($data) && $data->foto)
        <div class="mt-2">
            <small class="text-muted">Foto saat ini:</small><br>
            <img src="{{ asset('storage/karyawan/' . $data->foto) }}" alt="Foto" style="max-width: 100px; max-height: 100px; margin-top: 5px;">
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
    <select name="jenis_kelamin" class="form-control">
        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki" {{ (isset($data) && $data->jenis_kelamin=='Laki-laki')?'selected':'' }}>Laki-laki</option>
        <option value="Perempuan" {{ (isset($data) && $data->jenis_kelamin=='Perempuan')?'selected':'' }}>Perempuan</option>
    </select>
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
    <input type="text" name="pendidikan" class="form-control" value="{{ $data->pendidikan ?? '' }}" placeholder="Contoh: S1 Teknik Informatika">
</div>

<div class="mb-3">
    <label>Divisi</label>
    <select name="divisi_id" class="form-control" required>
        <option value="">-- Pilih Divisi --</option>
        @foreach($divisis as $div)
            <option value="{{ $div->id }}" {{ (isset($data) && $data->divisi_id == $div->id) ? 'selected' : '' }}>
                {{ $div->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Posisi</label>
    <input type="text" name="posisi" class="form-control" value="{{ $data->posisi ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Gaji</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" name="gaji" class="form-control" value="{{ $data->gaji ?? '' }}" placeholder="Masukkan gaji">
    </div>
    <small class="form-text text-muted d-block mt-1">Gaji dalam Rupiah (contoh: 5000000 untuk Rp 5.000.000)</small>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        <option value="Aktif" {{ (isset($data) && $data->status=='Aktif')?'selected':'' }}>Aktif</option>
        <option value="Tidak Aktif" {{ (isset($data) && $data->status=='Tidak Aktif')?'selected':'' }}>Tidak Aktif</option>
    </select>
</div>

<div class="mb-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control">{{ $data->keterangan ?? '' }}</textarea>
</div>
