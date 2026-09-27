<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingParticipant;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Get list training dengan pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search', '');

        $query = Training::orderBy('tanggal_mulai', 'desc');

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $trainings = $query->paginate($perPage);

        return response()->json([
            'message' => 'Data training',
            'data' => $trainings->items(),
            'pagination' => [
                'total' => $trainings->total(),
                'per_page' => $trainings->perPage(),
                'current_page' => $trainings->currentPage(),
                'last_page' => $trainings->lastPage(),
            ]
        ], 200);
    }

    /**
     * Get detail training
     */
    public function show($id)
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json([
                'message' => 'Training tidak ditemukan',
                'data' => null
            ], 404);
        }

        // Get participant count
        $participantCount = TrainingParticipant::where('training_id', $training->id)
            ->where('status', 'approved')
            ->count();

        $training->peserta_terdaftar = $participantCount;

        return response()->json([
            'message' => 'Detail training',
            'data' => $training
        ], 200);
    }

    /**
     * Enroll user ke training
     */
    public function enroll(Request $request, $id)
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json([
                'message' => 'Training tidak ditemukan',
                'data' => null
            ], 404);
        }

        $user = $request->user();

        // Check if already enrolled
        $existing = TrainingParticipant::where('training_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah terdaftar di training ini',
                'data' => null
            ], 422);
        }

        // Check kuota
        $participantCount = TrainingParticipant::where('training_id', $id)
            ->where('status', 'approved')
            ->count();

        if ($participantCount >= $training->kuota) {
            return response()->json([
                'message' => 'Kuota training sudah penuh',
                'data' => null
            ], 422);
        }

        // Create enrollment
        $participant = TrainingParticipant::create([
            'training_id' => $id,
            'user_id' => $user->id,
            'nik' => $user->nik,
            'status' => 'approved',
            'enrolled_at' => now(),
        ]);

        return response()->json([
            'message' => 'Anda berhasil terdaftar di training',
            'data' => $participant
        ], 201);
    }

    /**
     * Cancel enrollment
     */
    public function cancelEnrollment(Request $request, $id)
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json([
                'message' => 'Training tidak ditemukan',
                'data' => null
            ], 404);
        }

        $user = $request->user();

        $participant = TrainingParticipant::where('training_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$participant) {
            return response()->json([
                'message' => 'Anda tidak terdaftar di training ini',
                'data' => null
            ], 404);
        }

        $participant->delete();

        return response()->json([
            'message' => 'Pendaftaran training dibatalkan',
            'data' => null
        ], 200);
    }
}
