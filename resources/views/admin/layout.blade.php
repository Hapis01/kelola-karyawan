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
                font-size: 0.85rem;
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

            .btn-sm {
                width: auto;
            }

            .search-input {
                width: 100% !important;
            }

            .form-control,
            .form-select {
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
    </script>

    @stack('scripts')
</body>
</html>
