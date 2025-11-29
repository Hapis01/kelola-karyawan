<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Divisi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Exclude soft deleted karyawan
        $query = Karyawan::with('divisi')->whereNull('deleted_at');

        // Global search across several columns
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%")
                    ->orWhereHas('divisi', function ($div) use ($q) {
                        $div->where('nama', 'like', "%{$q}%");
                    })
                    ->orWhere('posisi', 'like', "%{$q}%");
            });
        }

        // Per-column filters (exact or partial match as appropriate)
        // Filter huruf_awal (A-Z starting letter)
        if ($request->filled('huruf_awal')) {
            $huruf = strtoupper($request->huruf_awal);
            $query->whereRaw('UPPER(LEFT(nama, 1)) = ?', [$huruf]);
        }

        if ($request->filled('nik')) {
            $query->where('nik', 'like', "%{$request->nik}%");
        }

        if ($request->filled('alamat')) {
            $query->where('alamat', 'like', "%{$request->alamat}%");
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('divisi')) {
            $query->whereHas('divisi', function ($div) use ($request) {
                $div->where('nama', 'like', "%{$request->divisi}%");
            });
        }

        if ($request->filled('posisi')) {
            $query->where('posisi', 'like', "%{$request->posisi}%");
        }

        if ($request->filled('status')) {
            $statusFilter = strtolower($request->status);

            // treat common non-active labels ('non', 'tidak') as group
            if (str_contains($statusFilter, 'non') || str_contains($statusFilter, 'tidak')) {
                $query->whereRaw("LOWER(status) LIKE ? OR LOWER(status) LIKE ?", ['%non%', '%tidak%']);
            } else {
                $query->whereRaw('LOWER(status) = ?', [$statusFilter]);
            }
        }

        // Filter gaji_range (predefined salary ranges)
        if ($request->filled('gaji_range')) {
            $range = $request->gaji_range;
            
            if ($range === '1-5000000') {
                $query->whereBetween('gaji', [1, 5000000]);
            } elseif ($range === '5000000-10000000') {
                $query->whereBetween('gaji', [5000000, 10000000]);
            } elseif ($range === '10000000-15000000') {
                $query->whereBetween('gaji', [10000000, 15000000]);
            } elseif ($range === '15000000+') {
                $query->where('gaji', '>=', 15000000);
            }
        }

        // Per-page and sorting
        $perPage = (int) $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $karyawans = $query->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        // More tolerant count for non-active: case-insensitive, match common keywords like 'non' or 'tidak'
        $total = Karyawan::count();
        $aktif = Karyawan::whereRaw('LOWER(status) = ?', [strtolower('Aktif')])->count();
        $nonAktif = Karyawan::whereRaw("LOWER(status) LIKE ? OR LOWER(status) LIKE ? OR LOWER(status) LIKE ?", ['%non%', '%tidak%', '%inactive%'])->count();

        return view('admin.dashboard', [
            'karyawans' => $karyawans,
            'divisis' => Divisi::orderBy('nama')->get(),
            'total' => $total,
            'aktif' => $aktif,
            'nonAktif' => $nonAktif,
            'totalDivisi' => Divisi::count(),
        ]);
    }
}