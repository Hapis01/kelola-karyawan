<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\KaryawanHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:100|unique:karyawans,nik',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
            'posisi' => 'required|string|max:255',
            'gaji' => 'nullable|numeric|min:0',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('karyawan', $filename, 'public');
            $data['foto'] = $filename;
        }

        $karyawan = Karyawan::create($data);

        // Log to history - create action
        KaryawanHistory::create([
            'karyawan_id' => $karyawan->id,
            'karyawan_nama' => $data['nama'],
            'action' => 'create',
            'new_data' => $data,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $k = Karyawan::findOrFail($id);
        
        // Delete old photo if exists
        if ($k->foto && Storage::disk('public')->exists('karyawan/' . $k->foto)) {
            Storage::disk('public')->delete('karyawan/' . $k->foto);
        }
        
        // Log to history - delete action before deleting
        KaryawanHistory::create([
            'karyawan_id' => $k->id,
            'karyawan_nama' => $k->nama,
            'action' => 'delete',
            'old_data' => $k->toArray(),
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        // Soft delete - tidak langsung hapus dari database
        $k->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Karyawan berhasil dihapus. Cek History untuk detail.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return response()->json($karyawan);
    }

    // Show edit form page
    public function editPage($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('admin.editkaryawan', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $k = Karyawan::findOrFail($id);
        
        // Store old data before update
        $oldData = $k->toArray();

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:100|unique:karyawans,nik,' . $k->id,
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
            'posisi' => 'required|string|max:255',
            'gaji' => 'nullable|numeric|min:0',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($k->foto && Storage::disk('public')->exists('karyawan/' . $k->foto)) {
                Storage::disk('public')->delete('karyawan/' . $k->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('karyawan', $filename, 'public');
            $data['foto'] = $filename;
        }

        $k->update($data);

        // Log to history - update action
        KaryawanHistory::create([
            'karyawan_id' => $k->id,
            'karyawan_nama' => $k->nama,
            'action' => 'update',
            'old_data' => $oldData,
            'new_data' => $data,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Karyawan berhasil diperbarui.');
    }
}
