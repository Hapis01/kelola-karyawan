<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan notifikasi center
     */
    public function index()
    {
        $admin = Auth::user();
        $notifications = Notification::where('admin_id', $admin->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::where('admin_id', $admin->id)
            ->unread()
            ->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notifikasi sebagai read
     */
    public function markAsRead(Notification $notification)
    {
        $admin = Auth::user();

        if ($notification->admin_id !== $admin->id) {
            abort(403, 'Unauthorized');
        }

        $notification->markAsRead();

        // Redirect ke detail yang terkait
        if ($notification->related_model === 'Training') {
            return redirect()->route('admin.training.show', ['training' => $notification->related_id]);
        } elseif ($notification->related_model === 'Leave') {
            return redirect()->route('admin.leave.show', ['leave' => $notification->related_id]);
        } elseif ($notification->related_model === 'KaryawanProfileUpdate') {
            return redirect()->route('admin.profile-updates.index');
        }

        return redirect()->back();
    }

    /**
     * Mark all sebagai read
     */
    public function markAllAsRead()
    {
        $admin = Auth::user();

        Notification::where('admin_id', $admin->id)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Semua notifikasi sudah ditandai sebagai dibaca');
    }

    /**
     * Get unread count (untuk AJAX/API)
     */
    public function getUnreadCount()
    {
        $admin = Auth::user();
        $count = Notification::where('admin_id', $admin->id)
            ->unread()
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}
