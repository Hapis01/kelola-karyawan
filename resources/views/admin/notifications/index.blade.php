@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Pusat Notifikasi</h3>
    @if ($unreadCount > 0)
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-check-double me-2"></i>Tandai Semua Sudah Dibaca
            </button>
        </form>
    @endif
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Tabs -->
<div class="table-container mb-4">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request('type') === '' ? 'active' : '' }}"
               href="{{ route('admin.notifications.index') }}">
                <i class="fas fa-bell me-2"></i>Semua Notifikasi
                @if ($unreadCount > 0)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') === 'training_upload' ? 'active' : '' }}"
               href="{{ route('admin.notifications.index', ['type' => 'training_upload']) }}">
                <i class="fas fa-certificate me-2"></i>Pelatihan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') === 'leave_request' ? 'active' : '' }}"
               href="{{ route('admin.notifications.index', ['type' => 'leave_request']) }}">
                <i class="fas fa-calendar-times me-2"></i>Cuti
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') === 'profile_update' ? 'active' : '' }}"
               href="{{ route('admin.notifications.index', ['type' => 'profile_update']) }}">
                <i class="fas fa-user-edit me-2"></i>Update Profil
            </a>
        </li>
    </ul>
</div>

<!-- Notifications List -->
<div class="table-container">
    @if ($notifications->count() > 0)
        <div class="notifications-list">
            @foreach ($notifications as $notification)
                <div class="notification-item p-3 mb-2 border-bottom {{ !$notification->is_read ? 'bg-light' : '' }}"
                     style="cursor: pointer; transition: all 0.3s;"
                     onclick="markAsRead({{ $notification->id }})">

                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="notification-icon">
                                @switch($notification->type)
                                    @case('training_upload')
                                        <i class="fas fa-certificate fa-2x text-warning"></i>
                                        @break
                                    @case('leave_request')
                                        <i class="fas fa-calendar-times fa-2x text-danger"></i>
                                        @break
                                    @case('profile_update')
                                        <i class="fas fa-user-edit fa-2x text-info"></i>
                                        @break
                                    @default
                                        <i class="fas fa-bell fa-2x text-primary"></i>
                                @endswitch
                            </div>
                        </div>

                        <div class="col">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $notification->title }}</h6>
                                    <p class="text-muted small mb-1">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                @if (!$notification->is_read)
                                    <span class="badge bg-primary rounded-circle ms-2" style="width: 10px; height: 10px; padding: 0;"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-bell-slash text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">
                @if (request('type'))
                    Tidak ada notifikasi tipe ini
                @else
                    Tidak ada notifikasi
                @endif
            </p>
        </div>
    @endif
</div>

<script>
function markAsRead(notificationId) {
    // Submit form programmatically
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/notifications/${notificationId}/read`;

    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = '{{ csrf_token() }}';

    form.appendChild(token);
    document.body.appendChild(form);
    form.submit();
}

// Auto-refresh every 30 seconds (for real-time feel)
setInterval(() => {
    // Optional: Could fetch unread count via AJAX and update badge
    // fetch('/admin/notifications/unread-count')
    //     .then(r => r.json())
    //     .then(data => {
    //         // Update badge
    //     });
}, 30000);
</script>

<style>
.notification-item {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
}

.notification-item:hover {
    background-color: #f0f0f0 !important;
    transform: translateX(5px);
}

.notification-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background-color: #f8f9fa;
    border-radius: 50%;
}
</style>

@endsection
