<?php

namespace App\Http\Controllers\Karyawan;

use App\Models\Leave;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Tampilkan daftar pengajuan cuti karyawan
     */
    public function index()
    {
        $user = Auth::user();
        $leaves = Leave::where('nik', $user->nik)
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        // Hitung sisa cuti tahunan (asumsi 12 hari per tahun)
        $annualLeaveUsed = Leave::where('nik', $user->nik)
            ->where('leave_type', 'annual')
            ->where('status', 'approved')
            ->whereYear('start_date', date('Y'))
            ->sum('days_count');

        $annualLeaveRemaining = 12 - $annualLeaveUsed;

        // Hitung jumlah status
        $pending_count = Leave::where('nik', $user->nik)
            ->where('status', 'pending')
            ->count();

        $approved_count = Leave::where('nik', $user->nik)
            ->where('status', 'approved')
            ->count();

        $rejected_count = Leave::where('nik', $user->nik)
            ->where('status', 'rejected')
            ->count();

        return view('karyawan.leave.index', compact('leaves', 'annualLeaveRemaining', 'annualLeaveUsed', 'pending_count', 'approved_count', 'rejected_count'));
    }

    /**
     * Form pengajuan cuti
     */
    public function create()
    {
        $user = Auth::user();

        // Hitung sisa cuti tahunan
        $annualLeaveUsed = Leave::where('nik', $user->nik)
            ->where('leave_type', 'annual')
            ->where('status', 'approved')
            ->whereYear('start_date', date('Y'))
            ->sum('days_count');

        $annualLeaveRemaining = 12 - $annualLeaveUsed;

        return view('karyawan.leave.create', compact('annualLeaveRemaining'));
    }

    /**
     * Store pengajuan cuti
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type' => 'required|in:annual,sick,personal,other',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10|max:500',
        ], [
            'leave_type.required' => 'Jenis cuti wajib dipilih',
            'start_date.required' => 'Tanggal mulai cuti wajib diisi',
            'start_date.after_or_equal' => 'Tanggal mulai cuti tidak boleh di masa lalu',
            'end_date.required' => 'Tanggal berakhir cuti wajib diisi',
            'end_date.after_or_equal' => 'Tanggal berakhir harus sama atau sesudah tanggal mulai',
            'reason.required' => 'Alasan cuti wajib diisi',
            'reason.min' => 'Alasan cuti minimal 10 karakter',
            'reason.max' => 'Alasan cuti maksimal 500 karakter',
        ]);

        $user = Auth::user();

        // Validasi cuti tahunan
        if ($validated['leave_type'] === 'annual') {
            $annualLeaveUsed = Leave::where('nik', $user->nik)
                ->where('leave_type', 'annual')
                ->where('status', 'approved')
                ->whereYear('start_date', date('Y'))
                ->sum('days_count');

            $annualLeaveRemaining = 12 - $annualLeaveUsed;
            $daysRequested = \Carbon\Carbon::parse($validated['start_date'])
                ->diffInDays(\Carbon\Carbon::parse($validated['end_date'])) + 1;

            if ($daysRequested > $annualLeaveRemaining) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Cuti tahunan Anda hanya tersisa {$annualLeaveRemaining} hari, tetapi Anda meminta {$daysRequested} hari");
            }
        }

        // Cek konflik tanggal dengan cuti yang sudah disetujui
        $conflict = Leave::where('nik', $user->nik)
            ->where('status', 'approved')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal cuti yang Anda ajukan bertabrakan dengan cuti yang sudah disetujui');
        }

        // Hitung jumlah hari
        $daysCount = \Carbon\Carbon::parse($validated['start_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['end_date'])) + 1;

        // Create leave request
        $leave = Leave::create([
            'nik' => $user->nik,
            'leave_type' => $validated['leave_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'days_count' => $daysCount,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        // Buat notifikasi untuk semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        $leaveTypeLabel = $this->getLeaveTypeLabel($validated['leave_type']);

        foreach ($admins as $admin) {
            Notification::create([
                'admin_id' => $admin->id,
                'nik' => $user->nik,
                'type' => 'leave_request',
                'title' => 'Pengajuan Cuti',
                'message' => "{$user->name} telah mengajukan cuti {$leaveTypeLabel} dari {$validated['start_date']} hingga {$validated['end_date']} ({$daysCount} hari)",
                'related_model' => 'Leave',
                'related_id' => $leave->id,
            ]);
        }

        return redirect()->route('karyawan.leave.index')
            ->with('success', 'Pengajuan cuti berhasil dikirim. Menunggu persetujuan admin.');
    }

    /**
     * Tampilkan detail cuti
     */
    public function show(Leave $leave)
    {
        $user = Auth::user();

        if ($leave->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        return view('karyawan.leave.show', compact('leave'));
    }

    /**
     * Edit pengajuan cuti (hanya jika pending)
     */
    public function edit(Leave $leave)
    {
        $user = Auth::user();

        if ($leave->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if ($leave->status !== 'pending') {
            return redirect()->route('karyawan.leave.index')
                ->with('error', 'Hanya pengajuan cuti dengan status pending yang bisa diedit');
        }

        $annualLeaveUsed = Leave::where('nik', $user->nik)
            ->where('leave_type', 'annual')
            ->where('status', 'approved')
            ->where('id', '!=', $leave->id)
            ->whereYear('start_date', date('Y'))
            ->sum('days_count');

        $annualLeaveRemaining = 12 - $annualLeaveUsed;

        return view('karyawan.leave.edit', compact('leave', 'annualLeaveRemaining'));
    }

    /**
     * Update pengajuan cuti
     */
    public function update(Request $request, Leave $leave)
    {
        $user = Auth::user();

        if ($leave->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if ($leave->status !== 'pending') {
            return redirect()->route('karyawan.leave.index')
                ->with('error', 'Hanya pengajuan cuti dengan status pending yang bisa diubah');
        }

        $validated = $request->validate([
            'leave_type' => 'required|in:annual,sick,personal,other',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10|max:500',
        ]);

        $leave->update($validated);

        return redirect()->route('karyawan.leave.index')
            ->with('success', 'Pengajuan cuti berhasil diperbarui');
    }

    /**
     * Batalkan pengajuan cuti
     */
    public function cancel(Leave $leave)
    {
        $user = Auth::user();

        if ($leave->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if (!in_array($leave->status, ['pending', 'approved'])) {
            return redirect()->route('karyawan.leave.index')
                ->with('error', 'Hanya cuti dengan status pending atau approved yang bisa dibatalkan');
        }

        $leave->update(['status' => 'cancelled']);

        return redirect()->route('karyawan.leave.index')
            ->with('success', 'Pengajuan cuti berhasil dibatalkan');
    }

    /**
     * Helper untuk label jenis cuti
     */
    private function getLeaveTypeLabel($type)
    {
        $labels = [
            'annual' => 'Cuti Tahunan',
            'sick' => 'Cuti Sakit',
            'personal' => 'Cuti Pribadi',
            'other' => 'Cuti Lainnya',
        ];

        return $labels[$type] ?? $type;
    }
}
