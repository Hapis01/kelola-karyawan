<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Tampilkan daftar semua pengajuan cuti
     */
    public function index(Request $request)
    {
        $query = Leave::with('karyawan', 'approvedBy');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan nik
        if ($request->has('nik') && $request->nik !== '') {
            $query->where('nik', $request->nik);
        }

        // Filter berdasarkan tahun
        if ($request->has('year') && $request->year !== '') {
            $query->whereYear('start_date', $request->year);
        }

        $leaves = $query->orderBy('start_date', 'desc')->paginate(20);
        $karyawans = Karyawan::all();

        // Get counts for statistics
        $pending_count = Leave::where('status', 'pending')->count();
        $approved_count = Leave::where('status', 'approved')->count();
        $rejected_count = Leave::where('status', 'rejected')->count();

        return view('admin.leave.index', compact('leaves', 'karyawans', 'pending_count', 'approved_count', 'rejected_count'));
    }

    /**
     * Tampilkan detail pengajuan cuti
     */
    public function show(Leave $leave)
    {
        $leave->load('karyawan', 'approvedBy');
        return view('admin.leave.show', compact('leave'));
    }

    /**
     * Approve leave
     */
    public function approve(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya pengajuan cuti dengan status pending yang bisa disetujui');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.leave.index')
            ->with('success', 'Pengajuan cuti berhasil disetujui');
    }

    /**
     * Reject leave
     */
    public function reject(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya pengajuan cuti dengan status pending yang bisa ditolak');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10|max:500',
        ], [
            'admin_notes.required' => 'Alasan penolakan wajib diisi',
            'admin_notes.min' => 'Alasan minimal 10 karakter',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->route('admin.leave.index')
            ->with('success', 'Pengajuan cuti berhasil ditolak');
    }

    /**
     * Lihat statistik cuti karyawan
     */
    public function statistics(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');

        $karyawans = Karyawan::with(['leaves' => function ($query) use ($year) {
            $query->where('status', 'approved')
                  ->whereYear('start_date', $year);
        }])->get();

        return view('admin.leave.statistics', compact('karyawans', 'year'));
    }
}
