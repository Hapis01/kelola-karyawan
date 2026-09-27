<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan | PT Pasifik Energi Trans</title>

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

        .content-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
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

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
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

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }

            .sidebar {
                width: 280px;
                max-width: 85vw;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                padding-bottom: 20px;
            }

            .sidebar-menu {
                max-height: calc(100vh - 250px);
            }

            .sidebar.hidden {
                transform: translateX(-100%);
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

            .alert {
                margin-top: 60px;
                font-size: 0.9rem;
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

    @include('karyawan.sidebar')

    <!-- Notification Toast (Global) -->
    <div id="notificationToast" class="notification-toast">
        <div class="toast-content">
            <i class="fas fa-bell me-2"></i>
            <span id="toastMessage">Ada pesan masuk</span>
        </div>
    </div>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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

        // Notification System
        class NotificationManager {
            constructor() {
                this.toast = document.getElementById('notificationToast');
                this.toastMessage = document.getElementById('toastMessage');
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
        }

        const notificationManager = new NotificationManager();

        // Optional: Listen for notification events
        // This function can be called from your notification service
        window.showNotification = function(message, type = 'info') {
            notificationManager.show(message, 5000);
        };
    </script>

    @stack('scripts')
</body>
</html>
