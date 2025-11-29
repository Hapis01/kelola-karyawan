<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KaryawanHistory;
use App\Models\UserHistory;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // Karyawan history query
        $karyawanQuery = KaryawanHistory::query();

        // Global search
        if ($request->filled('q')) {
            $q = $request->q;
            $karyawanQuery->where(function ($sub) use ($q) {
                $sub->where('karyawan_nama', 'like', "%{$q}%");
            });
        }

        // Filter by action
        if ($request->filled('action')) {
            $karyawanQuery->where('action', $request->action);
        }

        // Filter by name
        if ($request->filled('karyawan_nama')) {
            $karyawanQuery->where('karyawan_nama', 'like', "%{$request->karyawan_nama}%");
        }

        // User history query
        $userQuery = UserHistory::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $userQuery->where(function ($sub) use ($q) {
                $sub->where('user_email', 'like', "%{$q}%")
                    ->orWhere('user_email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('action')) {
            $userQuery->where('action', $request->action);
        }

        if ($request->filled('karyawan_nama')) {
            $userQuery->where('user_email', 'like', "%{$request->karyawan_nama}%");
        }

        // Per-page and sorting
        $perPage = (int) $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        // Get karyawan and user histories with proper sorting
        $karyawanHistories = $karyawanQuery->orderBy($sortBy, $sortDir)->get();
        $userHistories = $userQuery->orderBy($sortBy, $sortDir)->get();

        // Merge and sort all histories
        $allHistories = collect()
            ->merge($karyawanHistories->map(fn($h) => (object)[
                'id' => 'k' . $h->id,
                'action' => $h->action,
                'karyawan_nama' => $h->karyawan_nama,
                'user_email' => null,
                'old_data' => $h->old_data,
                'new_data' => $h->new_data,
                'created_at' => $h->created_at,
                'type' => 'karyawan',
            ]))
            ->merge($userHistories->map(fn($h) => (object)[
                'id' => 'u' . $h->id,
                'action' => $h->action,
                'karyawan_nama' => null,
                'user_email' => $h->user_email,
                'old_data' => $h->old_data,
                'new_data' => $h->new_data,
                'created_at' => $h->created_at,
                'type' => 'user',
            ]))
            ->sortByDesc('created_at')
            ->values();

        // Manual pagination for collection
        $page = Paginator::resolveCurrentPage();
        $total = $allHistories->count();
        $items = $allHistories->slice(($page - 1) * $perPage, $perPage)->values();

        $histories = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        // Get all divisis for mapping
        $divisis = Divisi::all()->keyBy('id');

        return view('admin.history', [
            'histories' => $histories,
            'divisis' => $divisis,
        ]);
    }
}

