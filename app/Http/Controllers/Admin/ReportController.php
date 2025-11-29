<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\KaryawanHistory;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $karyawans = Karyawan::with('divisi')->whereNull('deleted_at')->orderBy('id', 'asc')->get();
        $divisis = Divisi::all();

        return view('admin.report', [
            'karyawans' => $karyawans,
            'divisis' => $divisis,
        ]);
    }

    public function generatePDF(Request $request)
    {
        $selectedIds = $request->input('karyawan_ids', []);
        $typeReport = $request->input('type_report', 'selected'); // 'selected' atau 'all'

        // Get karyawans to generate - ensure all columns loaded including keterangan
        if ($typeReport === 'all') {
            $karyawans = Karyawan::with('divisi')
                ->whereNull('deleted_at')
                ->orderBy('id', 'asc')
                ->get();
        } else {
            $karyawans = Karyawan::with('divisi')
                ->whereNull('deleted_at')
                ->whereIn('id', $selectedIds)
                ->orderBy('id', 'asc')
                ->get();
        }

        if ($karyawans->isEmpty()) {
            return back()->with('error', 'Pilih minimal satu karyawan untuk dicetak');
        }

        // Get histories for each karyawan
        $histories = [];
        foreach ($karyawans as $karyawan) {
            $histories[$karyawan->id] = KaryawanHistory::where('karyawan_id', $karyawan->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        $pdf = PDF::loadView('admin.report-pdf', [
            'karyawans' => $karyawans,
            'histories' => $histories,
            'generatedAt' => now(),
        ])
        ->setPaper('a4')
        ->setOption('margin-top', 10)
        ->setOption('margin-right', 10)
        ->setOption('margin-bottom', 10)
        ->setOption('margin-left', 10)
        ->setOption('dpi', 150);

        return $pdf->stream('laporan-karyawan-' . date('Y-m-d-His') . '.pdf');
    }

    public function preview(Request $request)
    {
        $karyawanId = $request->input('karyawan_id');
        $karyawan = Karyawan::with('divisi')->findOrFail($karyawanId);
        $histories = KaryawanHistory::where('karyawan_id', $karyawanId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.report-preview', [
            'karyawan' => $karyawan,
            'histories' => $histories,
        ]);
    }
}
