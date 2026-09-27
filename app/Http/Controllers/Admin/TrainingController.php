<?php

namespace App\Http\Controllers\Admin;

use App\Models\Training;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    /**
     * Tampilkan daftar semua pelatihan untuk admin
     */
    public function index(Request $request)
    {
        $query = Training::with('karyawan', 'approvedBy');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan nik/karyawan
        if ($request->has('nik') && $request->nik !== '') {
            $query->where('nik', $request->nik);
        }

        $trainings = $query->orderBy('created_at', 'desc')->paginate(20);
        $karyawans = Karyawan::all();

        // Get counts for statistics
        $pending_count = Training::where('status', 'pending')->count();
        $approved_count = Training::where('status', 'approved')->count();
        $rejected_count = Training::where('status', 'rejected')->count();

        return view('admin.training.index', compact('trainings', 'karyawans', 'pending_count', 'approved_count', 'rejected_count'));
    }

    /**
     * Tampilkan detail training
     */
    public function show(Training $training)
    {
        $training->load('karyawan', 'approvedBy');
        return view('admin.training.show', compact('training'));
    }

    /**
     * Approve training
     */
    public function approve(Request $request, Training $training)
    {
        if ($training->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya training dengan status pending yang bisa diapprove');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $training->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.training.index')
            ->with('success', 'Pelatihan berhasil disetujui');
    }

    /**
     * Reject training
     */
    public function reject(Request $request, Training $training)
    {
        if ($training->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya training dengan status pending yang bisa ditolak');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10|max:500',
        ], [
            'admin_notes.required' => 'Alasan penolakan wajib diisi',
            'admin_notes.min' => 'Alasan minimal 10 karakter',
        ]);

        $training->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->route('admin.training.index')
            ->with('success', 'Pelatihan berhasil ditolak');
    }

    /**
     * Download sertifikat
     */
    public function downloadCertificate(Training $training)
    {
        $filePath = $training->certificate_file;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Hapus training
     */
    public function destroy(Training $training)
    {
        Storage::disk('public')->delete($training->certificate_file);
        $training->forceDelete();

        return redirect()->route('admin.training.index')
            ->with('success', 'Pelatihan berhasil dihapus');
    }
}
