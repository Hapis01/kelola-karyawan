<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Get list leave dengan pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $status = $request->query('status');
        $user = $request->user();

        $query = Leave::where('nik', $user->nik);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'message' => 'Data cuti',
            'data' => $leaves->items(),
            'pagination' => [
                'total' => $leaves->total(),
                'per_page' => $leaves->perPage(),
                'current_page' => $leaves->currentPage(),
                'last_page' => $leaves->lastPage(),
            ]
        ], 200);
    }

    /**
     * Get detail leave
     */
    public function show($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'message' => 'Data cuti tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Detail cuti',
            'data' => $leave
        ], 200);
    }

    /**
     * Create leave request
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:annual,sick,personal',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
            'days_count' => 'required|integer|min:1',
            'reason' => 'required|string|max:500',
        ]);

        $user = $request->user();

        // Check if leave dates overlap
        $overlapping = Leave::where('nik', $user->nik)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })
            ->exists();

        if ($overlapping) {
            return response()->json([
                'message' => 'Tanggal cuti bertabrakan dengan cuti yang sudah disetujui',
                'data' => null
            ], 422);
        }

        $leave = Leave::create([
            'nik' => $user->nik,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days_count' => $request->days_count,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Pengajuan cuti berhasil dibuat',
            'data' => $leave
        ], 201);
    }

    /**
     * Update leave request
     */
    public function update(Request $request, $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'message' => 'Data cuti tidak ditemukan',
                'data' => null
            ], 404);
        }

        // Only allow update if status is pending
        if ($leave->status !== 'pending') {
            return response()->json([
                'message' => 'Hanya cuti dengan status pending yang dapat diubah',
                'data' => null
            ], 422);
        }

        $request->validate([
            'leave_type' => 'sometimes|in:annual,sick,personal',
            'start_date' => 'sometimes|date|date_format:Y-m-d',
            'end_date' => 'sometimes|date|date_format:Y-m-d',
            'days_count' => 'sometimes|integer|min:1',
            'reason' => 'sometimes|string|max:500',
        ]);

        $leave->update($request->only([
            'leave_type', 'start_date', 'end_date', 'days_count', 'reason'
        ]));

        return response()->json([
            'message' => 'Data cuti diperbarui',
            'data' => $leave
        ], 200);
    }

    /**
     * Delete/Cancel leave request
     */
    public function destroy($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'message' => 'Data cuti tidak ditemukan',
                'data' => null
            ], 404);
        }

        // Only allow delete if status is pending
        if ($leave->status !== 'pending') {
            return response()->json([
                'message' => 'Hanya cuti dengan status pending yang dapat dibatalkan',
                'data' => null
            ], 422);
        }

        $leave->delete();

        return response()->json([
            'message' => 'Pengajuan cuti dibatalkan',
            'data' => null
        ], 200);
    }

    /**
     * Filter leave by status
     */
    public function filterByStatus($status)
    {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return response()->json([
                'message' => 'Status tidak valid',
                'data' => []
            ], 400);
        }

        $leaves = Leave::where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => "Data cuti dengan status {$status}",
            'data' => $leaves
        ], 200);
    }

    /**
     * Approve leave (admin only)
     */
    public function approve(Request $request, $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'message' => 'Data cuti tidak ditemukan',
                'data' => null
            ], 404);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return response()->json([
            'message' => 'Cuti disetujui',
            'data' => $leave
        ], 200);
    }

    /**
     * Reject leave (admin only)
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json([
                'message' => 'Data cuti tidak ditemukan',
                'data' => null
            ], 404);
        }

        $leave->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return response()->json([
            'message' => 'Cuti ditolak',
            'data' => $leave
        ], 200);
    }
}
