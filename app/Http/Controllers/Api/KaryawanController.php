<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Get list karyawan dengan pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search', '');

        $query = Karyawan::with('divisi');

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
        }

        $karyawans = $query->paginate($perPage);

        return response()->json([
            'message' => 'Data karyawan',
            'data' => $karyawans->items(),
            'pagination' => [
                'total' => $karyawans->total(),
                'per_page' => $karyawans->perPage(),
                'current_page' => $karyawans->currentPage(),
                'last_page' => $karyawans->lastPage(),
            ]
        ], 200);
    }

    /**
     * Get detail karyawan
     */
    public function show($nik)
    {
        $karyawan = Karyawan::where('nik', $nik)->with('divisi')->first();

        if (!$karyawan) {
            return response()->json([
                'message' => 'Karyawan tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Detail karyawan',
            'data' => $karyawan
        ], 200);
    }

    /**
     * Update karyawan
     */
    public function update(Request $request, $nik)
    {
        $karyawan = Karyawan::where('nik', $nik)->first();

        if (!$karyawan) {
            return response()->json([
                'message' => 'Karyawan tidak ditemukan',
                'data' => null
            ], 404);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string|max:20',
            'jabatan' => 'sometimes|string|max:100',
            'pendidikan' => 'sometimes|string|max:50',
            'jurusan' => 'sometimes|string|max:100',
        ]);

        $karyawan->update($request->only([
            'nama', 'email', 'phone', 'jabatan', 'pendidikan', 'jurusan'
        ]));

        return response()->json([
            'message' => 'Data karyawan diperbarui',
            'data' => $karyawan
        ], 200);
    }

    /**
     * Search karyawan
     */
    public function search(Request $request)
    {
        $search = $request->query('q', '');

        if (strlen($search) < 2) {
            return response()->json([
                'message' => 'Minimal 2 karakter',
                'data' => []
            ], 400);
        }

        $karyawans = Karyawan::with('divisi')
            ->where('nama', 'like', "%{$search}%")
            ->orWhere('nik', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json([
            'message' => 'Hasil pencarian',
            'data' => $karyawans
        ], 200);
    }
}
