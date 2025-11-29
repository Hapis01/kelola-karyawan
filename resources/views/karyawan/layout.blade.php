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
            overflow-y: auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1000;
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
        }

        .sidebar a:hover {
            background: #2b39a0;
        }

        .sidebar a.active {
            background: #2b39a0;
        }

        .logout-btn {
            background: #e33b3b !important;
            margin-top: 20px;
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

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }

            .sidebar {
                width: 100%;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
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
                padding: 8px 12px;
            }

            .alert {
                margin-top: 60px;
                font-size: 0.9rem;
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

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Close sidebar when a link is clicked
        const sidebarLinks = document.querySelectorAll('.sidebar a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', closeSidebar);
        });

        // Close sidebar on window resize (when back to desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
