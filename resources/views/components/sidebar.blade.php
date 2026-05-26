<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    {{-- ── BRAND AREA ── --}}
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="25" class="brand-logo-img">
            </span>
            <div class="brand-text-wrapper ms-2">
                <span class="app-brand-text demo fw-bolder"></span>
                <small class="school-label">SMKN 2 PADANG</small>
            </div>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- ── BERANDA ── --}}
        <li class="menu-item {{ Route::is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manajemen Arsip</span>
        </li>

        {{-- ── ARSIP SURAT (Siswa & Staff Bisa Liat) ── --}}
        <li class="menu-item {{ Route::is('transaction.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div>Arsip Surat</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('transaction.incoming.*') ? 'active' : '' }}">
                    <a href="{{ route('transaction.incoming.index') }}" class="menu-link">
                        <div>Surat Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('transaction.outgoing.*') ? 'active' : '' }}">
                    <a href="{{ route('transaction.outgoing.index') }}" class="menu-link">
                        <div>Surat Keluar</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ── AGENDA & REFERENSI (DISEMBUNYIKAN DARI SISWA) ── --}}
        @if(auth()->user()->role !== 'siswa')
            {{-- AGENDA --}}
            <li class="menu-item {{ Route::is('agenda.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-book-content"></i>
                    <div>Agenda Digital</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::is('agenda.incoming') ? 'active' : '' }}">
                        <a href="{{ route('agenda.incoming') }}" class="menu-link">
                            <div>Agenda Masuk</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::is('agenda.outgoing') ? 'active' : '' }}">
                        <a href="{{ route('agenda.outgoing') }}" class="menu-link">
                            <div>Agenda Keluar</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- REFERENSI --}}
            <li class="menu-item {{ Route::is('reference.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div>Referensi</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Route::is('reference.classification.*') ? 'active' : '' }}">
                        <a href="{{ route('reference.classification.index') }}" class="menu-link">
                            <div>Klasifikasi Surat</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- ── SISTEM (KHUSUS ADMIN) ── --}}
        @if(auth()->user()->role == 'admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Sistem</span>
            </li>
            <li class="menu-item {{ Route::is('user.*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-pin"></i>
                    <div>Kelola User</div>
                </a>
            </li>
        @endif

        {{-- ── LOGOUT ── --}}
        <li class="menu-item mt-3">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="javascript:void(0);" class="menu-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div>Keluar</div>
            </a>
        </li>
    </ul>
</aside>

<style>
    /* ── KUSTOM EMERALD STYLE LU ── */
    .brand-text-wrapper { display: flex; flex-direction: column; line-height: 1.1; }
    .app-brand-text { font-family: 'Syne', sans-serif; font-size: 1.2rem !important; color: var(--bs-heading-color) !important; text-transform: uppercase; }
    .school-label { font-size: 0.6rem; font-weight: 700; color: #10b981; letter-spacing: 0.5px; }
    .layout-menu-toggle { cursor: pointer !important; z-index: 10; }
    .light-style #layout-menu { background-color: #ffffff !important; }
    .dark-style #layout-menu { background-color: #0f172a !important; }
    .dark-style .brand-logo-img { filter: brightness(0) invert(1); }

    /* Emerald Active State */
    .menu-item.active > .menu-link {
        background-color: rgba(16, 185, 129, 0.12) !important;
        color: #10b981 !important;
        position: relative;
    }
    .menu-item.active > .menu-link::before {
        content: ""; position: absolute; left: 0; top: 25%; height: 50%; width: 4px; background: #10b981; border-radius: 0 4px 4px 0;
    }

    .menu-link { transition: all 0.2s ease-in-out !important; }
    .menu-inner::-webkit-scrollbar { width: 4px; }
    .menu-inner::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
</style>