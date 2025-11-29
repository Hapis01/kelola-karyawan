<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Pasifik Energi Trans - Home</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* ======================== NAVBAR ======================== */
        .navbar-custom {
            background: linear-gradient(135deg, #0d0b61 0%, #1a1785 100%);
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-custom .navbar-brand img {
            height: 50px;
            transition: transform 0.3s ease;
        }

        .navbar-custom .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .navbar-custom .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-left: 20px;
        }

        .navbar-custom .nav-link:hover {
            color: #ffc107 !important;
            transform: translateY(-2px);
        }

        /* ======================== HERO SECTION ======================== */
        .hero-section {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('{{ asset("assets/images/bg1.png") }}') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(13, 11, 97, 0.6) 0%, rgba(26, 23, 133, 0.4) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 700px;
            animation: fadeInDown 1s ease-out;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            letter-spacing: -1px;
            white-space: nowrap;
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 50px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
            font-weight: 300;
        }

        .hero-buttons {
            display: flex;
            flex-direction: column;
            gap: 25px;
            align-items: center;
            justify-content: center;
        }

        .btn-hero {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #0d0b61;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(255, 200, 7, 0.3);
            text-decoration: none;
            display: inline-block;
            width: 250px;
            text-align: center;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 200, 7, 0.5);
            background: linear-gradient(135deg, #ff9800 0%, #ffc107 100%);
            color: #0d0b61;
        }
        .about-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .about-title {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInUp 0.8s ease-out;
        }

        .about-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0d0b61;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .about-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border-radius: 2px;
        }

        .about-title p {
            font-size: 1.1rem;
            color: #666;
            margin-top: 20px;
        }

        .about-text {
            animation: slideInLeft 0.8s ease-out;
        }

        /* Misi Items */
        .misi-container {
            animation: slideInRight 0.8s ease-out;
        }

        .misi-item {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .misi-item:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .misi-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .misi-text h6 {
            color: #0d0b61;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .misi-text p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Company Images */
        .company-image-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            height: 280px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .company-image-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .company-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .company-image-card:hover .company-img {
            transform: scale(1.1);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(13, 11, 97, 0.8) 0%, rgba(255, 193, 7, 0.4) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .company-image-card:hover .image-overlay {
            opacity: 1;
        }

        .image-overlay p {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin: 0;
        }

        /* Animation untuk slideInRight */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animation untuk slideInLeft */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ======================== PARTNER SECTION ======================== */
        .partner-section {
            padding: 80px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .partner-title {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInUp 0.8s ease-out;
        }

        .partner-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0d0b61;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .partner-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border-radius: 2px;
        }

        .partner-title p {
            font-size: 1.1rem;
            color: #666;
            margin-top: 20px;
        }

        .partner-carousel-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            justify-content: center;
        }

        .partner-carousel {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 30px 20px;
            flex: 1;
            min-width: 0;
            scrollbar-width: thin;
            scrollbar-color: #ffc107 #e0e0e0;
        }

        .partner-carousel::-webkit-scrollbar {
            height: 8px;
        }

        .partner-carousel::-webkit-scrollbar-track {
            background: #e0e0e0;
            border-radius: 10px;
        }

        .partner-carousel::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border-radius: 10px;
        }

        .partner-carousel::-webkit-scrollbar-thumb:hover {
            background: #ff9800;
        }

        .partner-item {
            flex: 0 0 200px;
            background: white;
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            min-height: 150px;
        }

        .partner-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .partner-item img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .partner-item:hover img {
            transform: scale(1.1);
        }

        /* Carousel Controls */
        .carousel-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ffc107;
            background: white;
            color: #ffc107;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .carousel-btn:hover {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
            border-color: #ff9800;
            transform: scale(1.1);
        }

        .carousel-btn.left {
            order: -1;
        }

        /* ======================== FOOTER ======================== */
        .footer-custom {
            background: linear-gradient(135deg, #0d0b61 0%, #1a1785 100%);
            color: white;
            padding: 40px 0 20px;
            margin-top: 80px;
        }

        .footer-section {
            margin-bottom: 30px;
        }

        .footer-section h5 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #ffc107;
        }

        .footer-section p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.8;
        }

        .footer-bottom {
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-contact {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer-contact a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-contact a:hover {
            color: #ffc107;
        }

        /* Contact Item Styles */
        .contact-item {
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            padding-left: 10px;
        }

        .contact-method {
            transition: all 0.3s ease;
        }

        .contact-method:hover {
            transform: translateX(5px);
        }

        .contact-method a:hover {
            text-decoration: underline;
        }

        /* ======================== ANIMATIONS ======================== */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ======================== RESPONSIVE ======================== */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
                white-space: nowrap;
            }

            .hero-content p {
                font-size: 1rem;
                margin-bottom: 35px;
            }

            .hero-buttons {
                gap: 20px;
            }

            .btn-hero {
                padding: 12px 35px;
                font-size: 1rem;
                width: 220px;
            }

            .partner-title h2 {
                font-size: 1.8rem;
            }

            .about-title h2 {
                font-size: 1.8rem;
            }

            .partner-item {
                flex: 0 0 160px;
                min-height: 130px;
                padding: 20px 15px;
            }

            .navbar-custom .nav-link {
                margin-left: 10px;
                font-size: 0.9rem;
            }

            .misi-item {
                margin-bottom: 15px;
                padding: 15px;
            }

            .company-image-card {
                height: 220px;
            }

            .carousel-btn {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 1.5rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .hero-content p {
                font-size: 0.9rem;
                margin-bottom: 30px;
            }

            .hero-buttons {
                gap: 15px;
            }

            .btn-hero {
                padding: 12px 30px;
                font-size: 0.9rem;
                width: 200px;
            }

            .partner-item {
                flex: 0 0 130px;
                min-height: 110px;
                padding: 15px 12px;
            }

            .partner-title h2 {
                font-size: 1.5rem;
            }

            .about-title h2 {
                font-size: 1.5rem;
            }

            .misi-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .misi-icon {
                width: 45px;
                height: 45px;
            }

            .company-image-card {
                height: 200px;
            }

            .carousel-btn {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .partner-carousel-wrapper {
                gap: 10px;
            }
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- ======================== NAVBAR ======================== -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/images/logo12.png') }}" alt="Logo" style="height: 60px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ======================== HERO SECTION ======================== -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>PT Pasifik Energi Trans</h1>
            <p>Energi Industri & Logistik BBM Terpercaya</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-hero">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                </a>
                <a href="#footer" class="btn-hero">
                    <i class="fas fa-arrow-down me-2"></i>Jelajahi lebih
                </a>
            </div>
        </div>
    </section>

    <!-- ======================== ABOUT SECTION ======================== -->
    <section class="about-section" id="about">
        <div class="container">
            <!-- About Title -->
            <div class="about-title fade-in">
                <h2>Tentang Kami</h2>
                <p>Mengenal PT. Pasifik Energi Trans lebih dekat</p>
            </div>

            <!-- About Content -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 fade-in" style="animation-delay: 0.2s;">
                    <div class="about-text">
                        <h3 style="color: #0d0b61; font-weight: 700; margin-bottom: 20px;">Profil Perusahaan</h3>
                        
                        <p style="text-align: justify; line-height: 1.8; color: #555; margin-bottom: 20px;">
                            <strong>PT. Pasifik Energi Trans</strong> adalah perusahaan swasta nasional yang bergerak khusus di bidang usaha keagenan bahan bakar minyak industri yang mencakup seluruh wilayah Indonesia. Kami telah berdiri sejak 18 September 2012 dengan memiliki izin usaha penyaluran bahan bakar minyak.
                        </p>

                        <p style="text-align: justify; line-height: 1.8; color: #555; margin-bottom: 20px;">
                            Sesuai dengan Visi dan Misi kami, menjalankan pemasaran atau marketing yang terintegritas adalah satu keharusan yaitu dengan memberikan pelayanan, solusi dan produk yang tepat guna.
                        </p>

                        <div style="background: rgba(255, 193, 7, 0.1); padding: 20px; border-radius: 10px; border-left: 4px solid #ffc107;">
                            <h5 style="color: #0d0b61; font-weight: 700; margin-bottom: 15px;">
                                <i class="fas fa-star me-2" style="color: #ffc107;"></i>Visi
                            </h5>
                            <p style="color: #555; margin: 0; line-height: 1.7;">
                                Menjadi salah satu agen resmi BBM yang diakui intregitasnya oleh seluruh pelanggan kami dan menjadi perusahaan yang lebih maju lagi.
                            </p>
                        </div>
                    </div>
<p></p>
                </div>
                <!-- Misi -->
                <div class="col-lg-6 fade-in" style="animation-delay: 0.4s;">
                    <div class="misi-container">
                        <h3 style="color: #0d0b61; font-weight: 700; margin-bottom: 20px;">
                            <i class="fas fa-list-check me-2" style="color: #ffc107;"></i>Misi Kami
                        </h3>

                        <div class="misi-item">
                            <div class="misi-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="misi-text">
                                <h6>Menjaga Kualitas & Ketepatan Waktu</h6>
                                <p>Menjaga kualitas & ketepatan waktu pengiriman kepada semua pelanggan setia kami.</p>
                            </div>
                        </div>

                        <div class="misi-item">
                            <div class="misi-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="misi-text">
                                <h6>Mempermudah Transaksi</h6>
                                <p>Mempermudah transaksi bagi para pelanggan dengan menjaga komunikasi yang baik.</p>
                            </div>
                        </div>

                        <div class="misi-item">
                            <div class="misi-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="misi-text">
                                <h6>Hubungan Bisnis Baik</h6>
                                <p>Membina hubungan baik dengan distributor dan semua mitra kerjasama kami.</p>
                            </div>
                        </div>

                        <div class="misi-item">
                            <div class="misi-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="misi-text">
                                <h6>Pengembangan SDM</h6>
                                <p>Meningkatkan kualitas SDM secara kompetensi dan juga kesejahteraannya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Images -->
            <div class="company-images fade-in" style="animation-delay: 0.6s;">
                <h3 style="text-align: center; color: #0d0b61; font-weight: 700; margin-bottom: 40px;">Fasilitas & Operasional Kami</h3>
                
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="company-image-card">
                            <img src="{{ asset('assets/images/pusat.jpg') }}" alt="Fasilitas 1" class="company-img">
                            <div class="image-overlay">
                                <p>Kantor Pusat & Operasional</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="company-image-card">
                            <img src="{{ asset('assets/images/armada.jpg') }}" alt="Fasilitas 2" class="company-img">
                            <div class="image-overlay">
                                <p>Armada Transportasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="company-image-card">
                            <img src="{{ asset('assets/images/logistik.jpg') }}" alt="Fasilitas 3" class="company-img">
                            <div class="image-overlay">
                                <p>Area Logistik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== PARTNER SECTION ======================== -->
    <section class="partner-section" id="partner">
        <div class="container">
            <div class="partner-title fade-in">
                <h2>Partner Kami</h2>
                <p>Didukung oleh mitra terpercaya dari berbagai wilayah di seluruh Indonesia.</p>
            </div>

            <div class="partner-carousel-wrapper">
                <button class="carousel-btn left" id="scrollLeftBtn" title="Scroll Left">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="partner-carousel" id="partnerCarousel">
                    @php
                        $partners = [
                            'partner (1).jpg',
                            'partner (2).jpg',
                            'partner (3).jpg',
                            'partner (4).jpg',
                            'partner (5).jpg',
                            'partner (6).jpg',
                            'partner (7).jpg',
                            'partner (8).jpg',
                            'partner (9).jpg',
                            'partner (10).jpg',
                        ];
                    @endphp

                    @foreach($partners as $partner)
                    <div class="partner-item fade-in">
                        <img src="{{ asset('assets/partner/' . $partner) }}" alt="Partner Logo" loading="lazy">
                    </div>
                    @endforeach
                </div>

                <button class="carousel-btn right" id="scrollRightBtn" title="Scroll Right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ======================== FOOTER ======================== -->
    <footer class="footer-custom" id="footer">
        <div class="container">
            <div class="row">
                <!-- Lokasi -->
                <div class="col-lg-6 col-md-12 footer-section fade-in">
                    <h5><i class="fas fa-map-marker-alt me-2"></i>Lokasi</h5>
                    
                    <div class="contact-item mb-3">
                        <h6 style="color: #ffc107; font-weight: 700; margin-bottom: 8px;">
                            <i class="fas fa-map-pin me-2"></i>HEAD OFFICE
                        </h6>
                        <p style="font-size: 0.9rem; line-height: 1.6; margin-left: 24px;">
                            Jl. Datuk Rubiah LK. XXIX Kel. Rengas Pulau<br>
                            Kec. Medan Marelan Medan<br>
                            Sumatera Utara – 20255
                        </p>
                    </div>

                    <div class="contact-item mb-3">
                        <h6 style="color: #ffc107; font-weight: 700; margin-bottom: 8px;">
                            <i class="fas fa-map-pin me-2"></i>CABANG JAKARTA
                        </h6>
                        <p style="font-size: 0.9rem; line-height: 1.6; margin-left: 24px;">
                            Jl. Ende No.38, Kel. Tanjung Priok<br>
                            Kec. Tanjung Priok, Kota Jakarta Utara<br>
                            Provinsi DKI Jakarta – 14310
                        </p>
                    </div>

                    <div class="contact-item">
                        <h6 style="color: #ffc107; font-weight: 700; margin-bottom: 8px;">
                            <i class="fas fa-map-pin me-2"></i>CABANG BALI
                        </h6>
                        <p style="font-size: 0.9rem; line-height: 1.6; margin-left: 24px;">
                            Jl. Bypass Ngurah Rai, Pertokoan Puri Alit No. 9<br>
                            Kec. Kuta, Kab. Badung, Prov. Bali
                        </p>
                    </div>
                </div>

                <!-- Hubungi Kami -->
                <div class="col-lg-6 col-md-12 footer-section fade-in">
                    <h5><i class="fas fa-envelope me-2"></i>Hubungi Kami</h5>
                    
                    <div class="contact-method mb-4">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                            <div style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffc107;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">Telepon</p>
                                <a href="tel:+6281239682633" style="color: #ffc107; text-decoration: none; font-weight: 600;">081239682633</a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-method mb-4">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                            <div style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffc107;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">WhatsApp</p>
                                <a href="https://wa.me/6281239682633" target="_blank" style="color: #ffc107; text-decoration: none; font-weight: 600;">081239682633</a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                            <div style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffc107;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">Email</p>
                                <a href="mailto:admin@pasentra.com" style="color: #ffc107; text-decoration: none; font-weight: 600;">admin@pasentra.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <h8>&copy; 2025 PT Pasifik Energi Trans. All Rights Reserved.</h8>
                <br>
                <h10>Design by Hafiz Batubara</h10>
                    </br>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Partner Carousel Scroll
        const carousel = document.getElementById('partnerCarousel');
        const scrollLeftBtn = document.getElementById('scrollLeftBtn');
        const scrollRightBtn = document.getElementById('scrollRightBtn');

        const scrollAmount = 300;

        scrollLeftBtn.addEventListener('click', () => {
            carousel.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        scrollRightBtn.addEventListener('click', () => {
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        // Fade in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

</body>
</html>
