<?php

namespace App\Http\Controllers\Karyawan;

use App\Models\Training;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    /**
     * Tampilkan daftar pelatihan karyawan
     */
    public function index()
    {
        $user = Auth::user();
        $trainings = Training::where('nik', $user->nik)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('karyawan.training.index', compact('trainings'));
    }

    /**
     * Form upload sertifikasi pelatihan
     */
    public function create()
    {
        return view('karyawan.training.create');
    }

    /**
     * Store sertifikasi pelatihan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'training_name' => 'required|string|max:255',
            'training_date' => 'required|date|before_or_equal:today',
            'training_provider' => 'required|string|max:255',
            'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'description' => 'nullable|string|max:1000',
        ], [
            'training_name.required' => 'Nama pelatihan wajib diisi',
            'training_date.required' => 'Tanggal pelatihan wajib diisi',
            'training_date.before_or_equal' => 'Tanggal pelatihan tidak boleh melebihi hari ini',
            'training_provider.required' => 'Penyelenggara pelatihan wajib diisi',
            'certificate_file.required' => 'File sertifikat wajib diupload',
            'certificate_file.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG',
            'certificate_file.max' => 'Ukuran file maksimal 5MB',
        ]);

        $user = Auth::user();

        // Upload file
        $filePath = $request->file('certificate_file')->store(
            "trainings/{$user->nik}",
            'public'
        );

        // Create training record
        $training = Training::create([
            'nik' => $user->nik,
            'training_name' => $validated['training_name'],
            'training_date' => $validated['training_date'],
            'training_provider' => $validated['training_provider'],
            'certificate_file' => $filePath,
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        // Buat notifikasi untuk semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'admin_id' => $admin->id,
                'nik' => $user->nik,
                'type' => 'training_upload',
                'title' => 'Unggahan Sertifikat Pelatihan',
                'message' => "{$user->name} telah mengupload sertifikat pelatihan: {$validated['training_name']}",
                'related_model' => 'Training',
                'related_id' => $training->id,
            ]);
        }

        return redirect()->route('karyawan.training.index')
            ->with('success', 'Sertifikat pelatihan berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Tampilkan detail pelatihan
     */
    public function show(Training $training)
    {
        $user = Auth::user();

        // Pastikan hanya user sendiri yang bisa melihat
        if ($training->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        return view('karyawan.training.show', compact('training'));
    }

    /**
     * Edit pelatihan (hanya jika pending)
     */
    public function edit(Training $training)
    {
        $user = Auth::user();

        if ($training->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if ($training->status !== 'pending') {
            return redirect()->route('karyawan.training.index')
                ->with('error', 'Hanya pelatihan dengan status pending yang bisa diedit');
        }

        return view('karyawan.training.edit', compact('training'));
    }

    /**
     * Update pelatihan
     */
    public function update(Request $request, Training $training)
    {
        $user = Auth::user();

        if ($training->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if ($training->status !== 'pending') {
            return redirect()->route('karyawan.training.index')
                ->with('error', 'Hanya pelatihan dengan status pending yang bisa diubah');
        }

        $validated = $request->validate([
            'training_name' => 'required|string|max:255',
            'training_date' => 'required|date|before_or_equal:today',
            'training_provider' => 'required|string|max:255',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'description' => 'nullable|string|max:1000',
        ]);

        // Jika ada file baru, hapus yang lama
        if ($request->hasFile('certificate_file')) {
            Storage::disk('public')->delete($training->certificate_file);
            $filePath = $request->file('certificate_file')->store(
                "trainings/{$user->nik}",
                'public'
            );
            $validated['certificate_file'] = $filePath;
        }

        $training->update($validated);

        return redirect()->route('karyawan.training.index')
            ->with('success', 'Pelatihan berhasil diperbarui');
    }

    /**
     * Hapus pelatihan (hanya jika pending)
     */
    public function destroy(Training $training)
    {
        $user = Auth::user();

        if ($training->nik !== $user->nik) {
            abort(403, 'Unauthorized');
        }

        if ($training->status !== 'pending') {
            return redirect()->route('karyawan.training.index')
                ->with('error', 'Hanya pelatihan dengan status pending yang bisa dihapus');
        }

        Storage::disk('public')->delete($training->certificate_file);
        $training->delete();

        return redirect()->route('karyawan.training.index')
            ->with('success', 'Pelatihan berhasil dihapus');
    }
}
