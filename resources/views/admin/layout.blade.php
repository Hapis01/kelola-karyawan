<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | PT Pasifik Energi Trans</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #e7e7e7;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: #10185f;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1000;
            transform: translateX(0);
            display: flex;
            flex-direction: column;
        }

        .sidebar img {
            width: 190px;
            display: block;
            margin: 0 auto 25px auto;
            flex-shrink: 0;
            object-fit: contain;
            max-height: 80px;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 5px;
            -webkit-overflow-scrolling: touch;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: #10185f;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #2b39a0;
            border-radius: 3px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: #3d4db8;
        }

        .sidebar-footer {
            flex-shrink: 0;
            padding: 15px 0;
            border-top: 1px solid #2b39a0;
            background: linear-gradient(to bottom, transparent, rgba(43, 57, 160, 0.1));
        }

        .sidebar.hidden {
            transform: translateX(-100%);
            box-shadow: none;
        }

        .sidebar img {
            width: 190px;
            display: block;
            margin: 0 auto 25px auto;
        }

        .sidebar a {
            display: block;
            padding: 13px 25px;
            color: white;
            font-size: 15px;
            text-decoration: none;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .sidebar a:hover {
            background: #2b39a0;
        }

        .sidebar a.active {
            background: #2b39a0;
        }

        .logout-btn {
            background: #e33b3b !important;
            margin-top: 10px;
            margin-bottom: 0 !important;
        }

        .sidebar-footer .logout-btn {
            margin-top: 0;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #10185f;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: #2b39a0;
            transform: scale(1.05);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            animation: fadeIn 0.3s ease;
        }

        /* Content Area */
        .content {
            margin-left: 260px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .dashboard-card {
            background: #f1f2ff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
        }

        /* Statistic Card Styles */
        .stat-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 5px 15px rgba(0,0,0,0.15);
        }

        .stat-card-icon {
            font-size: 2.5rem;
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-card-warning .stat-card-icon {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .stat-card-success .stat-card-icon {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .stat-card-danger .stat-card-icon {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .stat-card-primary .stat-card-icon {
            background: rgba(0, 123, 255, 0.15);
            color: #007bff;
        }

        .stat-card-body {
            flex: 1;
        }

        .stat-card-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            box-shadow: 0px 3px 10px rgba(0,0,0,0.15);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 10;
        }

        .search-input {
            border-radius: 8px;
            padding: 7px 10px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Modal Responsiveness */
        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 500;
        }

        /* Page Header Responsiveness */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .page-header h3 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .page-header .btn {
            white-space: nowrap;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            /* Mobile - sidebar hidden by default */
            .sidebar {
                width: 280px;
                max-width: 85vw;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                transform: translateX(-100%);
                padding-bottom: 20px;
            }

            .sidebar-menu {
                max-height: calc(100vh - 250px);
            }

            .sidebar.hidden {
                transform: translateX(-100%);
            }

            /* Sidebar visible when not hidden */
            .sidebar:not(.hidden) {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .content {
                margin-left: 0;
                padding: 20px;
                padding-top: 70px;
            }

            .content h3 {
                font-size: 1.5rem;
            }

            .page-header {
                gap: 0.5rem;
                margin-bottom: 1.5rem;
            }

            .page-header h3 {
                flex: 1 1 100%;
                font-size: 1.3rem;
            }

            .page-header .btn {
                flex-shrink: 0;
            }

            .page-header .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .stat-card-icon {
                width: 60px;
                height: 60px;
                font-size: 2rem;
                margin: 0 auto;
            }

            .stat-card-value {
                font-size: 1.5rem;
            }

            .sidebar-menu {
                max-height: calc(100vh - 280px);
            }

            .sidebar-footer {
                padding: 12px 0;
                margin-top: auto;
            }

            .sidebar-footer a {
                padding: 10px 20px;
                font-size: 14px;
            }

            .dashboard-card {
                padding: 15px;
                margin-bottom: 15px;
            }

            .dashboard-card h2 {
                font-size: 1.5rem;
            }

            .table-container {
                padding: 15px;
                margin-bottom: 15px;
                font-size: 0.9rem;
            }

            .table {
                margin-bottom: 0;
                font-size: 0.85rem;
            }

            .table-container h5 {
                font-size: 1.1rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
                font-size: 0.9rem;
                padding: 12px 16px;
                min-height: 44px;
                touch-action: manipulation;
            }

            .btn-sm {
                width: auto;
                padding: 8px 12px;
                min-height: 40px;
            }

            .search-input {
                width: 100% !important;
            }

            .form-control,
            .form-select {
                font-size: 0.9rem;
                min-height: 40px;
                padding: 10px 12px;
            }

            .form-label {
                margin-bottom: 8px;
                font-weight: 500;
            }

            label {
                font-size: 0.95rem;
            }

            input[type="checkbox"],
            input[type="radio"] {
                width: 18px;
                height: 18px;
                margin-top: 4px;
            }

            .modal {
                padding-right: 0 !important;
            }

            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100vw - 1rem);
            }

            .modal-content {
                border-radius: 8px;
            }

            .modal-header {
                padding: 0.75rem;
            }

            .modal-title {
                font-size: 1rem;
            }

            .modal-body {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .modal-footer {
                padding: 0.75rem;
            }

            .modal-footer .btn {
                padding: 8px 12px;
                margin-bottom: 5px;
            }
        }

        @media (min-width: 769px) {
            /* Desktop - sidebar always visible */
            .sidebar {
                transform: translateX(0) !important;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            .sidebar.hidden {
                transform: translateX(0) !important;
            }

            .sidebar-toggle {
                display: none !important;
            }

            .sidebar-overlay {
                display: none !important;
            }
        }

        @media (min-width: 577px) and (max-width: 768px) {
            /* Tablet - improved spacing */
            .content {
                padding: 20px;
                padding-top: 75px;
            }

            .sidebar {
                width: 260px;
            }

            .dashboard-card {
                padding: 15px;
            }

            .table-container {
                padding: 15px;
                font-size: 0.9rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .btn {
                padding: 10px 14px;
                font-size: 0.9rem;
            }

            h3 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 15px;
                padding-top: 60px;
            }

            .dashboard-card {
                padding: 12px;
                margin-bottom: 12px;
            }

            .table-container {
                padding: 12px;
                margin-bottom: 12px;
            }

            .table {
                font-size: 0.75rem;
            }

            .btn {
                padding: 6px 10px;
                font-size: 0.85rem;
            }

            h3 {
                font-size: 1.3rem;
            }

            h5 {
                font-size: 1rem;
            }

            .search-input {
                font-size: 0.85rem !important;
            }
        }

        /* Notification Toast Styles */
        .notification-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #10185f 0%, #2b39a0 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 2000;
            animation: slideInRight 0.4s ease;
            min-width: 300px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-toast:hover {
            transform: translateX(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
        }

        .notification-toast.show {
            display: flex;
            align-items: center;
        }

        .toast-content {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .notification-toast.hide {
            animation: slideOutRight 0.4s ease;
        }

        /* Sidebar section headers */
        .sidebar h6 {
            color: #99a3b3;
            font-size: 0.75rem;
            padding: 12px 25px 8px;
            margin: 15px 0 0 0;
            font-weight: 600;
            text-transform: uppercase;
        }

        .sidebar h6:first-of-type {
            margin-top: 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
        }

        .sidebar a .badge {
            margin-left: auto;
            animation: badgePulse 2s infinite;
        }

        @keyframes badgePulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @media (max-width: 576px) {
            .notification-toast {
                bottom: 15px;
                right: 15px;
                min-width: 280px;
                padding: 12px 16px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @include('admin.sidebar')

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('hidden');
            sidebarOverlay.classList.toggle('show');
        }

        function closeSidebar() {
            sidebar.classList.add('hidden');
            sidebarOverlay.classList.remove('show');
        }

        function openSidebar() {
            sidebar.classList.remove('hidden');
            sidebarOverlay.classList.remove('show');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Close sidebar when a link is clicked (mobile only)
        const sidebarLinks = document.querySelectorAll('.sidebar a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });

        // Handle window resize - close on mobile, open on desktop
        function handleResize() {
            if (window.innerWidth > 768) {
                // Desktop mode - sidebar should always be visible
                openSidebar();
            } else {
                // Mobile mode - sidebar should be hidden by default
                closeSidebar();
            }
        }

        window.addEventListener('resize', handleResize);

        // Initialize sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            handleResize();
        });

        // Add Karyawan modal helpers (reset, focus, auto-open on validation error)
        (function() {
            const addModalEl = document.getElementById('addKaryawanModal');
            const addModal = addModalEl ? new bootstrap.Modal(addModalEl) : null;

            // Reset form and clear validation UI when modal is hidden
            if (addModalEl) addModalEl.addEventListener('hidden.bs.modal', function () {
                const form = addModalEl.querySelector('form');
                if (!form) return;
                form.reset();
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            });

            // Focus the first input when shown
            if (addModalEl) addModalEl.addEventListener('shown.bs.modal', function () {
                const first = addModalEl.querySelector('input,select,textarea,button');
                if (first) first.focus();
            });

            // Auto-open modal when store validation fails and we are on admin.dashboard
            @if ($errors->any() && request()->routeIs('admin.dashboard'))
                document.addEventListener('DOMContentLoaded', function () {
                    addModal.show();
                });
            @endif

            // Convert any explicit trigger to open the add modal instead (no route dependency)
            document.querySelectorAll('[data-open="add-karyawan-modal"]').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (addModal) addModal.show();
                });
            });
            // Edit Karyawan modal helpers
            const editModalEl = document.getElementById('editKaryawanModal');
            if (editModalEl) {
                const editModal = new bootstrap.Modal(editModalEl);

                // Reset on hide
                editModalEl.addEventListener('hidden.bs.modal', function () {
                    const form = editModalEl.querySelector('#editKaryawanForm');
                    if (!form) return;
                    form.reset();
                    const hiddenId = document.getElementById('editing_id');
                    if (hiddenId) hiddenId.value = '';
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                });

                // Focus first field on show
                editModalEl.addEventListener('shown.bs.modal', function () {
                    const first = editModalEl.querySelector('input,select,textarea');
                    if (first) first.focus();
                });

                // Handle edit buttons: fetch JSON, fill form, set action, then show
                document.addEventListener('click', function(e) {
                    const btn = e.target.closest('.btn-edit-karyawan');
                    if (!btn) return;
                    const id = btn.dataset.id;
                    if (!id) return;

                    fetch(`{{ url('/admin/karyawan') }}/${id}/edit`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.json())
                        .then(data => {
                            const form = document.getElementById('editKaryawanForm');
                            if (!form) return;
                            form.action = `{{ url('/admin/karyawan') }}/${id}/update`;
                            const hiddenId = document.getElementById('editing_id');
                            if (hiddenId) hiddenId.value = id;

                            const setVal = (sel, val) => { const el = form.querySelector(sel); if (el) el.value = val ?? ''; };
                            setVal('[name="nama"]', data.nama);
                            setVal('[name="nik"]', data.nik);
                            setVal('[name="alamat"]', data.alamat);
                            setVal('[name="jenis_kelamin"]', data.jenis_kelamin);
                            setVal('[name="divisi"]', data.divisi);
                            setVal('[name="posisi"]', data.posisi);
                            setVal('[name="status"]', data.status);
                            setVal('[name="keterangan"]', data.keterangan);

                            editModal.show();
                        })
                        .catch(err => {
                            console.error('Error loading karyawan:', err);
                            alert('Gagal memuat data karyawan. Muat ulang halaman dan coba lagi.');
                        });
                });

                // Auto-open modal with old input after validation error
                @if ($errors->any() && request()->routeIs('admin.dashboard') && old('editing_id'))
                document.addEventListener('DOMContentLoaded', function () {
                    const id = {!! json_encode(old('editing_id')) !!};
                    const form = document.getElementById('editKaryawanForm');
                    if (!form) return;
                    form.action = `{{ url('/admin/karyawan') }}/${id}/update`;
                    const hiddenId = document.getElementById('editing_id');
                    if (hiddenId) hiddenId.value = id;

                    const setVal = (name, val) => { const el = form.querySelector(`[name="${name}"]`); if (el) el.value = val ?? ''; };
                    setVal('nama', {!! json_encode(old('nama')) !!});
                    setVal('nik', {!! json_encode(old('nik')) !!});
                    setVal('alamat', {!! json_encode(old('alamat')) !!});
                    setVal('jenis_kelamin', {!! json_encode(old('jenis_kelamin')) !!});
                    setVal('divisi', {!! json_encode(old('divisi')) !!});
                    setVal('posisi', {!! json_encode(old('posisi')) !!});
                    setVal('status', {!! json_encode(old('status')) !!});
                    setVal('keterangan', {!! json_encode(old('keterangan')) !!});

                    (new bootstrap.Modal(editModalEl)).show();
                });
                @endif
            }
        })();

        // Notification System
        class NotificationManager {
            constructor() {
                this.toast = document.getElementById('notificationToast');
                this.toastMessage = document.getElementById('toastMessage');
                this.badge = document.getElementById('notification-badge');
                this.hideTimeout = null;
            }

            show(message, duration = 4000) {
                if (this.hideTimeout) clearTimeout(this.hideTimeout);

                this.toastMessage.textContent = message;
                this.toast.classList.remove('hide');
                this.toast.classList.add('show');

                this.hideTimeout = setTimeout(() => {
                    this.toast.classList.add('hide');
                    setTimeout(() => {
                        this.toast.classList.remove('show', 'hide');
                    }, 400);
                }, duration);
            }

            updateBadge(count) {
                if (count > 0) {
                    this.badge.textContent = count;
                    this.badge.style.display = 'inline-block';
                } else {
                    this.badge.style.display = 'none';
                }
            }
        }

        const notificationManager = new NotificationManager();

        // Load unread notifications count
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("admin.notifications.index") }}?unread=true', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(r => r.text())
            .then(html => {
                // Parse unread count from HTML
                const match = html.match(/unread["\']?\s*:\s*(\d+)|<span[^>]*id=["\']unread-count["\'][^>]*>(\d+)</i);
                const count = match ? parseInt(match[1] || match[2]) : 0;
                notificationManager.updateBadge(count);
            })
            .catch(() => {
                // Silently fail
            });
        });

        // Optional: Listen for notification events (if implementing WebSocket/Pusher)
        // This function can be called from your notification service
        window.showNotification = function(message, type = 'info') {
            notificationManager.show(message, 5000);
        };
    </script>

    @stack('scripts')
</body>
</html>
