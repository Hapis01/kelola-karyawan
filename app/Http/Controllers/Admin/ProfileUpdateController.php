<?php

namespace App\Http\Controllers\Admin;

use App\Models\KaryawanProfileUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateController extends Controller
{
    /**
     * Tampilkan daftar pengajuan update profil
     */
    public function index(Request $request)
    {
        $query = KaryawanProfileUpdate::with('karyawan', 'approvedBy');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $updates = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.profile-updates.index', compact('updates'));
    }

    /**
     * Approve profile update
     */
    public function approve(Request $request, KaryawanProfileUpdate $update)
    {
        if ($update->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya update dengan status pending yang bisa disetujui');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        // Update data karyawan
        $karyawan = $update->karyawan;
        $fieldName = $update->field_name;
        $karyawan->update([
            $fieldName => $update->new_value,
        ]);

        // Update status pengajuan
        $update->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.profile-updates.index')
            ->with('success', 'Perubahan profil berhasil disetujui dan diterapkan');
    }

    /**
     * Reject profile update
     */
    public function reject(Request $request, KaryawanProfileUpdate $update)
    {
        if ($update->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya update dengan status pending yang bisa ditolak');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10|max:500',
        ], [
            'admin_notes.required' => 'Alasan penolakan wajib diisi',
            'admin_notes.min' => 'Alasan minimal 10 karakter',
        ]);

        $update->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->route('admin.profile-updates.index')
            ->with('success', 'Perubahan profil berhasil ditolak');
    }
}
