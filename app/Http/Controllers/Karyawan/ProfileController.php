<?php

namespace App\Http\Controllers\Karyawan;

use App\Models\Karyawan;
use App\Models\KaryawanProfileUpdate;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil karyawan
     */
    public function show()
    {
        $user = Auth::user();
        $karyawan = Karyawan::where('nik', $user->nik)->firstOrFail();

        return view('karyawan.profile.show', compact('karyawan'));
    }

    /**
     * Tampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        $karyawan = Karyawan::where('nik', $user->nik)->firstOrFail();

        // Ambil pending updates
        $pendingUpdates = KaryawanProfileUpdate::where('nik', $user->nik)
            ->where('status', 'pending')
            ->get();

        return view('karyawan.profile.edit', compact('karyawan', 'pendingUpdates'));
    }

    /**
     * Store profile update request
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $karyawan = Karyawan::where('nik', $user->nik)->firstOrFail();

        // Validasi input - hanya field tertentu yang bisa diedit
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_telepon' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.max' => 'Nama maksimal 255 karakter',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'no_telepon.max' => 'No telepon maksimal 20 karakter',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'tempat_lahir.max' => 'Tempat lahir maksimal 255 karakter',
            'pendidikan.max' => 'Pendidikan maksimal 255 karakter',
            'jurusan.max' => 'Jurusan maksimal 255 karakter',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($karyawan->foto) {
                Storage::disk('public')->delete('karyawan/' . $karyawan->foto);
            }

            // Store new photo
            $photoName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('karyawan', $photoName, 'public');

            // Update foto directly (no need for approval)
            $karyawan->update(['foto' => $photoName]);
        }

        // Filter hanya yang berbeda dengan data lama untuk profile updates yang perlu approval
        $updates = [];
        $editableFields = ['nama', 'alamat', 'no_telepon', 'tanggal_lahir', 'tempat_lahir', 'pendidikan', 'jurusan', 'jenis_kelamin'];

        foreach ($editableFields as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null) {
                $oldValue = $karyawan->$field;
                $newValue = $validated[$field];

                // Hanya buat record jika ada perubahan
                if ($oldValue !== $newValue) {
                    $updates[] = [
                        'nik' => $user->nik,
                        'field_name' => $field,
                        'old_value' => (string)$oldValue,
                        'new_value' => (string)$newValue,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Jika ada foto tapi tidak ada field lain
        if (!empty($updates) || $request->hasFile('foto')) {
            if (!empty($updates)) {
                // Insert semua updates yang perlu approval
                KaryawanProfileUpdate::insert($updates);

                // Buat notifikasi untuk semua admin
                $admins = \App\Models\User::where('role', 'admin')->get();
                $fieldNames = implode(', ', array_map(fn($u) => $u['field_name'], $updates));

                foreach ($admins as $admin) {
                    Notification::create([
                        'admin_id' => $admin->id,
                        'nik' => $user->nik,
                        'type' => 'profile_update',
                        'title' => 'Permintaan Update Profil',
                        'message' => "{$user->name} meminta perubahan data: {$fieldNames}",
                        'related_model' => 'KaryawanProfileUpdate',
                    ]);
                }
            }

            return redirect()->route('karyawan.profile.edit')
                ->with('success', 'Perubahan profil berhasil disimpan. Permohonan perubahan data sedang menunggu persetujuan admin.');
        }

        // Jika tidak ada perubahan apapun
        return redirect()->back()
            ->with('info', 'Tidak ada perubahan data yang perlu disimpan');
    }

    /**
     * Tampilkan riwayat perubahan profil
     */
    public function history()
    {
        $user = Auth::user();
        $updates = KaryawanProfileUpdate::where('nik', $user->nik)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('karyawan.profile.history', compact('updates'));
    }

    /**
     * Batalkan pengajuan perubahan (hanya jika pending)
     */
    public function cancelUpdate(KaryawanProfileUpdate $update)
    {
        $user = Auth::user();

        if ($update->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if ($update->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status pending yang bisa dibatalkan');
        }

        $update->delete();

        return redirect()->back()
            ->with('success', 'Permintaan perubahan berhasil dibatalkan');
    }
}
