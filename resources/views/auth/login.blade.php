<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Login | {{ config('app.name') }}</title>

    <!-- Hanya Inter — 1 font, 3 weight, ringan -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet"/>

    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --bg:        #090917;
            --bg-left:   #0b0f1e;
            --bg-form:   #0f0f23;
            --input:     #1a2236;
            --input-f:   #1e293b;
            --border:    #1e2d45;
            --accent:    #667eea;
            --accent-d:  #5a6fd6;
            --t1:        #e2e8f0;
            --t2:        #94a3b8;
            --t3:        #475569;
            --err-bg:    rgba(239,68,68,.1);
            --err-br:    rgba(239,68,68,.3);
            --err-t:     #fca5a5;
            --r:         9px;
        }

        html, body { height:100%; font-family:'Inter',system-ui,sans-serif; background:var(--bg); color:var(--t1); }

        .wrap { display:flex; min-height:100vh; overflow:hidden; }

        /* ── LEFT ── */
        .left {
            flex:1; display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            padding:48px 40px; background:var(--bg-left);
            position:relative; overflow:hidden;
        }

        /* Rotating rings — pure CSS, zero JS */
        .ring { position:absolute; border-radius:50%; border:1px solid rgba(102,126,234,.1); animation:rotRing linear infinite; }
        .ring-1 { width:320px; height:320px; top:-100px; left:-100px; animation-duration:35s; }
        .ring-2 { width:240px; height:240px; bottom:-80px; right:-80px; animation-duration:25s; animation-direction:reverse; }
        .ring-3 { width:160px; height:160px; top:50%; left:50%; margin:-80px 0 0 -80px; animation-duration:18s; border-color:rgba(102,126,234,.07); }
        @keyframes rotRing { to { transform:rotate(360deg); } }

        .logo-ring {
            width:96px; height:96px; border-radius:50%;
            background:rgba(102,126,234,.1); border:2px solid rgba(102,126,234,.22);
            display:flex; align-items:center; justify-content:center;
            margin-bottom:24px; position:relative; z-index:2;
            animation:popIn .7s cubic-bezier(.175,.885,.32,1.275) .1s both;
        }
        @keyframes popIn {
            from { opacity:0; transform:scale(.3) rotate(-180deg); }
            to   { opacity:1; transform:scale(1)  rotate(0); }
        }
        .logo-ring img { width:60px; height:60px; object-fit:contain; }

        .brand { text-align:center; z-index:2; animation:slideUp .6s ease .4s both; }
        @keyframes slideUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .brand h1   { font-size:1.65rem; font-weight:700; color:var(--t1); margin-bottom:6px; }
        .brand p    { font-size:.875rem; color:var(--t2); margin-bottom:3px; }
        .brand span { font-size:.95rem;  font-weight:600; color:var(--accent); }

        /* ── RIGHT ── */
        .right {
            flex:1; display:flex; align-items:center; justify-content:center;
            padding:40px 32px; background:var(--bg-form);
        }

        .card { width:100%; max-width:420px; animation:slideRight .7s ease .25s both; }
        @keyframes slideRight {
            from { opacity:0; transform:translateX(28px); }
            to   { opacity:1; transform:translateX(0); }
        }

        .fhead { margin-bottom:26px; }
        .fhead h2 { font-size:1.4rem; font-weight:700; color:var(--t1); margin-bottom:5px; }
        .fhead p  { font-size:.85rem; color:var(--t3); }

        .fg { margin-bottom:16px; }
        .fg:nth-child(2) { animation:fadeUp .55s ease .60s both; }
        .fg:nth-child(3) { animation:fadeUp .55s ease .72s both; }
        .chk-row         { animation:fadeUp .55s ease .84s both; }
        .btn-row         { animation:fadeUp .55s ease .96s both; }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .fg label {
            display:block; font-size:.72rem; font-weight:500;
            text-transform:uppercase; letter-spacing:.55px;
            color:var(--t2); margin-bottom:6px;
        }

        .form-control {
            width:100%; padding:11px 14px;
            background:var(--input); border:1.5px solid var(--border);
            border-radius:var(--r); color:var(--t1);
            font-size:.9rem; font-family:inherit; outline:none;
            transition:border-color .2s, background .2s, box-shadow .2s;
        }
        .form-control:focus { border-color:var(--accent); background:var(--input-f); box-shadow:0 0 0 3px rgba(102,126,234,.14); }
        .form-control::placeholder { color:var(--t3); }
        .form-control.is-invalid   { border-color:rgba(239,68,68,.6); }

        .pw-wrap { position:relative; }
        .pw-wrap .form-control { padding-right:42px; }
        .toggle-pwd {
            position:absolute; right:13px; top:50%; transform:translateY(-50%);
            background:none; border:none; cursor:pointer; color:var(--t3);
            padding:0; display:flex; transition:color .2s;
        }
        .toggle-pwd:hover { color:var(--accent); }

        .chk-row { display:flex; align-items:center; gap:8px; margin-bottom:20px; }
        .chk-row input[type="checkbox"] { width:15px; height:15px; accent-color:var(--accent); cursor:pointer; }
        .chk-row label { font-size:.85rem; color:var(--t2); cursor:pointer; }

        .btn-login {
            width:100%; padding:12px; background:var(--accent);
            border:none; border-radius:var(--r); color:white;
            font-size:.95rem; font-weight:600; font-family:inherit; cursor:pointer;
            transition:background .2s, transform .15s, box-shadow .2s;
        }
        .btn-login:hover    { background:var(--accent-d); transform:translateY(-1px); box-shadow:0 6px 18px rgba(102,126,234,.28); }
        .btn-login:active   { transform:translateY(0); box-shadow:none; }
        .btn-login:disabled { opacity:.65; cursor:not-allowed; transform:none; }

        .spinner {
            display:inline-block; width:13px; height:13px;
            border:2px solid rgba(255,255,255,.3); border-top-color:white;
            border-radius:50%; animation:sp .6s linear infinite;
            vertical-align:middle; margin-right:6px;
        }
        @keyframes sp { to { transform:rotate(360deg); } }

        .alert {
            display:flex; align-items:flex-start; gap:9px;
            padding:11px 14px; border-radius:var(--r); margin-bottom:18px;
            font-size:.85rem; animation:fadeDown .35s ease;
        }
        @keyframes fadeDown {
            from { opacity:0; transform:translateY(-6px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .alert-danger { background:var(--err-bg); border:1px solid var(--err-br); color:var(--err-t); }
        .alert svg    { flex-shrink:0; margin-top:1px; }

        /* ── MOBILE ── */
        @media (max-width:768px) {
            .wrap  { flex-direction:column; }
            .left  { flex:none; padding:28px 20px 24px; }
            .logo-ring { width:70px; height:70px; margin-bottom:14px; }
            .logo-ring img { width:44px; height:44px; }
            .brand h1   { font-size:1.2rem; }
            .brand p    { font-size:.78rem; }
            .brand span { font-size:.82rem; }
            .ring-1 { width:200px; height:200px; top:-60px;  left:-60px;  }
            .ring-2 { width:150px; height:150px; bottom:-50px; right:-50px; }
            .ring-3 { display:none; }
            .right { flex:1; padding:24px 18px 32px; align-items:flex-start; }
            .card  { max-width:100%; }
            .fhead h2       { font-size:1.15rem; }
            .form-control   { padding:10px 13px; font-size:.875rem; }
            .btn-login      { padding:11px; font-size:.9rem; }
        }

        @media (max-width:380px) {
            .left  { padding:22px 16px 18px; }
            .right { padding:18px 16px 28px; }
        }
    </style>
</head>

<body>
<div class="wrap">

    {{-- ── LEFT PANEL ── --}}
    <div class="left">
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>

        <div class="logo-ring">
            <img src="{{ asset('logo-black.png') }}" alt="Logo SMKN 2 Padang">
        </div>

        <div class="brand">
            <h1>Selamat Datang</h1>
            <p>Sistem Manajemen Surat</p>
            <span>SMKN 2 Padang</span>
        </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="right">
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-danger" id="errAlert">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="fhead">
                <h2>Login ke Akun Anda</h2>
                <p>Masukkan username dan password untuk melanjutkan</p>
            </div>

            <form id="loginForm" action="{{ route('login.post') }}" method="POST" novalidate>
                @csrf

                <div class="fg">
                    <label for="username">Username / Email</label>
                    <input
                        type="text"
                        class="form-control @error('username') is-invalid @enderror"
                        id="username"
                        name="username"
                        placeholder="Masukkan username atau email"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        autofocus
                        required
                    >
                </div>

                <div class="fg">
                    <label for="password">Password</label>
                    <div class="pw-wrap">
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pwd" id="togglePwd" aria-label="Tampilkan/sembunyikan password">
                            <svg id="eyeShow" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeHide" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="chk-row">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat saya</label>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-login" id="btnLogin">
                        <span id="btnText">Masuk</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    /* Toggle password */
    var pwdEl   = document.getElementById('password');
    var eyeShow = document.getElementById('eyeShow');
    var eyeHide = document.getElementById('eyeHide');
    document.getElementById('togglePwd').addEventListener('click', function () {
        var isHidden = pwdEl.type === 'password';
        pwdEl.type            = isHidden ? 'text'  : 'password';
        eyeShow.style.display = isHidden ? 'none'  : 'block';
        eyeHide.style.display = isHidden ? 'block' : 'none';
    });

    /* Loading state */
    document.getElementById('loginForm').addEventListener('submit', function () {
        var btn  = document.getElementById('btnLogin');
        var txt  = document.getElementById('btnText');
        btn.disabled  = true;
        txt.innerHTML = '<span class="spinner"></span>Memproses...';
    });

    /* Auto-dismiss error */
    var ea = document.getElementById('errAlert');
    if (ea) {
        setTimeout(function () {
            ea.style.transition = 'opacity .4s, transform .4s';
            ea.style.opacity    = '0';
            ea.style.transform  = 'translateY(-6px)';
            setTimeout(function () { ea.remove(); }, 400);
        }, 5000);
    }
</script>
</body>
</html>