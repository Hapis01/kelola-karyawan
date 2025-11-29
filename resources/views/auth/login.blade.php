<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Pasifik Energi Trans</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ======================== NAVBAR ======================== */
        .navbar-top {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            padding: 0;
            background: transparent;
            box-shadow: none;
        }

        .navbar-home-btn {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #0d0b61;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        .navbar-home-btn:hover {
            background: linear-gradient(135deg, #ff9800 0%, #ffc107 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
            color: #0d0b61;
            text-decoration: none;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('/assets/images/foto1.png') center/cover no-repeat fixed;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* LOGIN CARD - DENGAN ANIMASI */
        .login-card {
            width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 35px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: all 0.4s ease;
            transform: translateY(0);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .login-card img.logo {
            height: 80px;
            margin-bottom: 20px;
            transition: transform 0.5s ease;
        }

        .login-card:hover img.logo {
            transform: scale(1.05);
        }

        .login-title {
            color: #0d0b61;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 24px;
            letter-spacing: 0.5px;
        }

        .input-style {
            height: 48px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding-left: 15px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .input-style:focus {
            border-color: #0d0b61;
            box-shadow: 0 0 0 0.2rem rgba(13, 11, 97, 0.15);
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d0b61, #1a1785);
            color: white;
            border: none;
            height: 48px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(13, 11, 97, 0.3);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #090749, #0d0b61);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 11, 97, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-password {
            display: block;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #0d0b61;
        }

        /* ANIMASI FADE IN */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            animation: fadeIn 0.8s ease-out;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .navbar-home-btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                width: 90%;
                padding: 30px 25px;
            }

            .navbar-top {
                top: 15px;
                left: 15px;
            }

            .navbar-home-btn {
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .navbar-home-btn span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR DENGAN BACK BUTTON -->
    <nav class="navbar-top">
        <a href="{{ route('home') }}" class="navbar-home-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Home</span>
        </a>
    </nav>

    <!-- LOGIN CARD DI TENGAH LAYAR -->
    <div class="login-card">

        <img src="/assets/images/logo2.png" class="logo" alt="Logo Pasentra">

        <h5 class="login-title">MASUK</h5>

        @if ($errors->any())
            <div class="alert alert-danger py-3 mb-3" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-circle me-2 mt-1 flex-shrink-0" style="color: #dc3545;"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        @if ($errors->isEmpty() && session('error'))
                            <div>{{ session('error') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger py-3 mb-3" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-times-circle me-2 mt-1 flex-shrink-0" style="color: #dc3545;"></i>
                    <div>
                        <strong>Login Gagal!</strong><br>
                        <small>{{ session('error') }}</small>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <input type="email" name="email" class="form-control input-style" placeholder="Email" value="{{ old('email') }}" required autofocus>
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
            </div>

            <div class="input-group">
                <input type="password" name="password" class="form-control input-style" placeholder="Password" required>
                <span class="input-icon"><i class="fas fa-lock"></i></span>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk
            </button>

            <a href="#" class="forgot-password">
                <i class="fas fa-key me-1"></i>Lupa kata sandi?
            </a>
        </form>

    </div>

    <script>
        // Menambahkan efek ketikan pada input
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-style');
            
            inputs.forEach(input => {
                // Efek fokus dengan animasi
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Efek hover pada card dengan delay
            const card = document.querySelector('.login-card');
            let hoverTimeout;
            
            card.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                hoverTimeout = setTimeout(() => {
                    this.style.transform = 'translateY(-5px)';
                }, 100);
            });
            
            card.addEventListener('mouseleave', function() {
                clearTimeout(hoverTimeout);
                this.style.transform = 'translateY(0)';
            });
        });
    </script>

</body>
</html>