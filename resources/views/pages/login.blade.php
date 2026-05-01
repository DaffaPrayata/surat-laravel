<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>{{ __('menu.auth.login') }} | {{ config('app.name') }}</title>
    <meta name="description" content=""/>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('sneat/img/favicon/favicon.ico')}}"/>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet"/>
    
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('sneat/vendor/fonts/boxicons.css')}}"/>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('sneat/vendor/css/core.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/vendor/css/theme-default.css')}}"/>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* LEFT SIDE - Welcome Section */
        .welcome-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -200px;
            left: -200px;
            animation: float 6s ease-in-out infinite;
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -150px;
            right: -150px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .school-logo {
            width: 180px;
            height: 180px;
            object-fit: contain;
            margin-bottom: 40px;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
            animation: logoEntry 1s ease-out;
            z-index: 2;
        }

        @keyframes logoEntry {
            from {
                opacity: 0;
                transform: scale(0.5) rotate(-10deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        .welcome-text {
            text-align: center;
            color: white;
            z-index: 2;
        }

        .welcome-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            opacity: 0;
            animation: slideUp 0.8s ease-out 0.3s forwards;
            text-shadow: 2px 4px 12px rgba(0, 0, 0, 0.2);
        }

        .welcome-subtitle {
            font-size: 1.5rem;
            font-weight: 400;
            opacity: 0;
            animation: slideUp 0.8s ease-out 0.6s forwards;
            color: rgba(255, 255, 255, 0.95);
            letter-spacing: 1px;
        }

        .school-name {
            font-size: 2rem;
            font-weight: 600;
            margin-top: 10px;
            opacity: 0;
            animation: slideUp 0.8s ease-out 0.9s forwards;
            background: linear-gradient(to right, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RIGHT SIDE - Login Form */
        .form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            animation: formEntry 0.8s ease-out 0.4s both;
        }

        @keyframes formEntry {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-header {
            margin-bottom: 35px;
        }

        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #566a7f;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #a1acb8;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #566a7f;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #d9dee3;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: #696cff;
            box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a1acb8;
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #696cff;
        }

        .form-check {
            margin-bottom: 24px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
        }

        .form-check-label {
            color: #566a7f;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .spinner-border {
            width: 18px;
            height: 18px;
            border-width: 2px;
            vertical-align: middle;
            margin-right: 8px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-container {
                flex-direction: column;
            }

            .welcome-section {
                padding: 40px 20px;
                min-height: 40vh;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .welcome-subtitle {
                font-size: 1.1rem;
            }

            .school-name {
                font-size: 1.5rem;
            }

            .school-logo {
                width: 120px;
                height: 120px;
                margin-bottom: 25px;
            }

            .form-section {
                padding: 30px 20px;
            }
        }

        @media (max-width: 576px) {
            .welcome-title {
                font-size: 1.5rem;
            }

            .welcome-subtitle {
                font-size: 1rem;
            }

            .school-name {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- LEFT SIDE - Welcome Section with Animation -->
        <div class="welcome-section">
            <img src="{{ asset('logo-black.png') }}" alt="Logo SMKN 2 Padang" class="school-logo">
            
            <div class="welcome-text">
                <h1 class="welcome-title"> Datang</h1>
                <p class="welcome-subtitle">di Sistem Informasi</p>
                <h2 class="school-name">SMKN 2 Padang</h2>
            </div>
        </div>

        <!-- RIGHT SIDE - Login Form -->
        <div class="form-section">
            <div class="login-card">
                <div class="login-header">
                    <h2>Login ke Akun Anda</h2>
                    <p>Masukkan username dan password untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class='bx bx-error-circle'></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="formAuthentication" action="{{ route('login.post') }}" method="POST">
                    
                    <div class="form-group">
                    <label for="login">Username / Email</label>
                    <input 
                        type="text" 
                        class="form-control @error('username') is-invalid @enderror" 
                        id="login" 
                        name="username"
                        placeholder="Masukkan username atau email"
                        value="{{ old('username') }}"
                        autofocus
                        required
                     >
                    </div>


                    <!-- Password Field with Toggle -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Masukkan password"
                                required
                            >
                            <i class="bx bx-show toggle-password" id="togglePassword"></i>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login" id="btnLogin">
                        <span id="btnText">Masuk</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            
            this.classList.toggle('bx-show');
            this.classList.toggle('bx-hide');
        });

        // Form Submit Loading State
        const form = document.getElementById('formAuthentication');
        const btnLogin = document.getElementById('btnLogin');
        const btnText = document.getElementById('btnText');

        form.addEventListener('submit', function(e) {
            btnLogin.disabled = true;
            btnText.innerHTML = '<span class="spinner-border"></span> Memproses...';
        });

        // Auto-hide error after 5 seconds
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.animation = 'slideDown 0.4s ease-out reverse';
                setTimeout(() => alert.remove(), 400);
            }, 5000);
        }
    </script>
</body>
</html>