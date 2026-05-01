<style>
    #layout-navbar {
        /* Glassmorphism Effect */
        background: rgba(15, 15, 15, 0.9) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        
        /* Industrial Border */
        border-bottom: 1px solid #2d2d2d;
        box-shadow: none !important;
        
        /* Full Width & Alignment Fix */
        width: 100% !important;
        margin: 0 !important;
        padding: 0.5rem 1.5rem !important;
        border-radius: 0 !important;
        
        /* Layering */
        z-index: 1100 !important; 
        position: sticky;
        top: 0;
    }

    /* Desktop Search Box */
    .search-input-wrapper {
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 4px 12px;
        display: flex;
        align-items: center;
        transition: 0.3s ease;
    }

    .search-input-wrapper:focus-within {
        border-color: #10b981;
        background: #222;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .search-input-wrapper input {
        background: transparent !important;
        color: #fff !important;
        font-size: 0.85rem;
    }

    /* Avatar Ring */
    .avatar-online img {
        border: 2px solid #2d2d2d;
        padding: 2px;
        background: #111;
    }

    /* Dropdown Industrial */
    .dropdown-menu-dark {
        background-color: #121212 !important;
        border: 1px solid #2d2d2d !important;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
    }

    .dropdown-item:hover {
        background-color: rgba(16, 185, 129, 0.1) !important;
        color: #10b981 !important;
    }

    /* Custom spacing for Mobile */
    @media (max-width: 991.98px) {
        .navbar-nav-right {
            padding: 0 !important;
        }
    }
</style>

<nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
    <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">
        
        <div class="d-flex align-items-center">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="bx bx-menu bx-sm text-white"></i>
                </a>
            </div>

            <form action="{{ url()->current() }}" class="d-none d-lg-block m-0">
                <div class="search-input-wrapper">
                    <i class="bx bx-search fs-5 text-muted me-2"></i>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        class="form-control border-0 shadow-none p-0"
                        placeholder="Cari surat..."
                        style="width: 260px;"
                    />
                </div>
            </form>
        </div>

        <div class="d-block d-lg-none text-center">
            <span class="fw-bold text-white" style="letter-spacing: 2px; font-size: 0.9rem;">E-SURAT</span>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ auth()->user()->profile_picture }}" alt class="w-px-40 h-auto rounded-circle"/>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                    <li>
                        <a class="dropdown-item py-2" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ auth()->user()->profile_picture }}" alt class="w-px-40 h-auto rounded-circle"/>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-bold d-block text-white">{{ auth()->user()->name }}</span>
                                    <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><div class="dropdown-divider border-secondary"></div></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="bx bx-user me-2 text-success"></i>
                            <span class="align-middle">Profil Saya</span>
                        </a>
                    </li>
                    @if(auth()->user()->role == 'admin')
                    <li>
                        <a class="dropdown-item" href="{{ route('settings.show') }}">
                            <i class="bx bx-cog me-2 text-warning"></i>
                            <span class="align-middle">Pengaturan</span>
                        </a>
                    </li>
                    @endif
                    <li><div class="dropdown-divider border-secondary"></div></li>
                    <li>
                        <form action="{{ route('logout') }}" method="post" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>