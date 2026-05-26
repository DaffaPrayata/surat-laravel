@extends('layout.main')

@push('style')
<style>
    /* Emerald Dark Theme Custom */
    .card { background: #1a1a1a !important; border: 1px solid #2d2d2d !important; color: #f8fafc !important; border-radius: 12px; }
    .table { color: #cbd5e1 !important; }
    .table thead th { background-color: #252525 !important; color: #10b981 !important; border: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
    .table td { border-bottom: 1px solid #2d2d2d !important; }
    .table-hover tbody tr:hover { background-color: rgba(16, 185, 129, 0.05) !important; }

    .btn-emerald { background: #10b981 !important; color: white !important; border: none; transition: 0.3s; }
    .btn-emerald:hover { background: #059669 !important; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    
    .modal-content { background: #1a1a1a !important; color: #fff !important; border: 1px solid #334155; }
    .form-control, .form-select { background: #0f172a !important; border: 1px solid #334155 !important; color: #fff !important; }
    .form-control:focus { border-color: #10b981 !important; box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important; }
    
    .code-password { background: #0f172a; border: 1px solid #10b981; color: #10b981; cursor: pointer; font-family: monospace; transition: 0.3s; }
    .code-password:hover { background: #10b981; color: #000; }

    /* Mobile Card Style */
    .mobile-card {
        background: #1a1a1a;
        border: 1px solid #2d2d2d;
        border-radius: 12px;
        margin-bottom: 1rem;
        padding: 15px;
    }
    .data-label { font-size: 0.65rem; color: #6c757d; text-transform: uppercase; font-weight: 800; display: block; margin-bottom: 2px; }
    .value-text { color: #fff; font-weight: 500; }

    /* Responsive View Logic */
    @media (max-width: 767.98px) {
        .desktop-view { display: none; }
        .mobile-view { display: block; }
    }
    @media (min-width: 768px) {
        .desktop-view { display: block; }
        .mobile-view { display: none; }
    }
</style>
@endpush

@push('script')
<script>
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $('#editForm').attr('action', '{{ url("user") }}/' + id);
        $('#edit_name').val($(this).data('name'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_phone').val($(this).data('phone'));
        
        // Menggunakan value asli ('staff' / 'admin' / 'siswa') agar select option Javascript cocok
        $('#edit_role').val($(this).data('role'));
        $('#edit_active').prop('checked', $(this).data('active') == 1);
    });

    function copyPassword() {
        const pwd = document.getElementById("generatedPwd").innerText;
        navigator.clipboard.writeText(pwd);
        alert("Password berhasil disalin ke clipboard!");
    }
</script>
@endpush

@section('content')
<x-breadcrumb :values="['User', 'Daftar User']"></x-breadcrumb>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-white m-0"><i class="bx bx-user-circle me-2 text-success"></i>Manajemen User</h4>
    @if(auth()->user()->role === 'admin')
    <button class="btn btn-emerald shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bx bx-plus-circle me-1"></i> Tambah User
    </button>
    @endif
</div>

{{-- ALERT PASSWORD --}}
@if(session('success_user'))
<div class="alert d-flex align-items-center border-0 shadow mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 5px solid #10b981 !important;">
    <i class="bx bx-shield-quarter text-success fs-3 me-3"></i>
    <div class="text-white">
        <div class="fw-bold text-success">{{ session('success_user.message') }}</div>
        <span class="small">Klik password untuk menyalin: 
            <code id="generatedPwd" onclick="copyPassword()" class="px-3 py-1 rounded code-password ms-1">{{ session('success_user.password') }}</code>
        </span>
    </div>
    <button class="btn-close btn-close-white ms-auto" data-bs-alert="alert"></button>
</div>
@endif

<div class="card desktop-view shadow-lg border-0">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email & Kontak</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff" class="rounded me-3" style="width:38px;">
                            <div class="fw-bold text-white">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td><span class="text-white small">{{ $user->email }}</span><br><small class="text-muted">{{ $user->phone ?? '-' }}</small></td>
                    <td>
                        {{-- 🛠️ FIX CLEAN CODE: Memanggil method label() dari Enum Role --}}
                        <span class="badge bg-label-info">
                            {{ $user->role instanceof \App\Enums\Role ? $user->role->label() : (\App\Enums\Role::tryFrom($user->role)?->label() ?? ucfirst($user->role)) }}
                        </span>
                    </td>
                    <td><span class="badge {{ $user->is_active ? 'bg-label-success' : 'bg-label-danger' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="text-center">
                        @if(auth()->user()->role === 'admin')
                        <div class="d-flex justify-content-center gap-2">
                            {{-- data-role dikirim menggunakan data string asli dari DB ('staff') agar JavaScript dropdown sinkron --}}
                            <button class="btn btn-sm btn-info btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-role="{{ $user->role instanceof \App\Enums\Role ? $user->role->value : $user->role }}" data-active="{{ $user->is_active }}" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('user.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mobile-view">
    @forelse($data as $user)
    <div class="mobile-card shadow-sm">
        <div class="d-flex align-items-center mb-3 border-bottom border-secondary pb-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff" class="rounded me-3" style="width:40px;">
            <div class="flex-grow-1">
                <div class="fw-bold text-white">{{ $user->name }}</div>
                {{-- 🛠️ FIX MOBILE VIEW LABEL --}}
                <span class="badge bg-label-info small">
                    {{ $user->role instanceof \App\Enums\Role ? $user->role->label() : (\App\Enums\Role::tryFrom($user->role)?->label() ?? ucfirst($user->role)) }}
                </span>
            </div>
            @if(auth()->user()->role === 'admin')
            <div class="dropdown">
                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded fs-4 text-muted"></i></button>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                    <button class="dropdown-item btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-role="{{ $user->role instanceof \App\Enums\Role ? $user->role->value : $user->role }}" data-active="{{ $user->is_active }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit User</button>
                    <form action="{{ route('user.destroy', $user) }}" method="POST">@csrf @method('DELETE')<button class="dropdown-item text-danger">Hapus User</button></form>
                </div>
            </div>
            @endif
        </div>
        <div class="row g-2">
            <div class="col-6">
                <span class="data-label">Status</span>
                <span class="badge {{ $user->is_active ? 'bg-label-success' : 'bg-label-danger' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            <div class="col-6 text-end">
                <span class="data-label">Kontak</span>
                <span class="value-text small text-muted">{{ $user->phone ?? '-' }}</span>
            </div>
            <div class="col-12 mt-2">
                <span class="data-label">Email</span>
                <span class="value-text small">{{ $user->email }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted bg-dark rounded border border-secondary">Data Kosong</div>
    @endforelse
</div>

<div class="mt-4">{!! $data->links() !!}</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title text-white">Tambah User Baru</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-12"><label class="form-label small fw-bold text-uppercase">Nama Lengkap</label><input name="name" class="form-control" placeholder="Contoh: Muhammad Daffa" required></div>
                <div class="col-md-6"><label class="form-label small fw-bold text-uppercase">Username</label><input name="username" class="form-control" placeholder="daffaprayata" required></div>
                {{-- 🛠️ FIX HTML SINTAKS: Tag <select> pembuka yang rusak sudah diperbaiki dengan benar --}}
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-uppercase">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin">Administrator</option>
                        <option value="staff" selected>Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>
                <div class="col-12"><label class="form-label small fw-bold text-uppercase">Email Address</label><input name="email" type="email" class="form-control" placeholder="daffa@example.com" required></div>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="submit" class="btn btn-emerald w-100 fw-bold py-2">SIMPAN USER</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editForm" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title text-white">Edit User</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-12"><label class="form-label small fw-bold text-uppercase">Nama Lengkap</label><input id="edit_name" name="name" class="form-control" required></div>
                <div class="col-12"><label class="form-label small fw-bold text-uppercase">Email Address</label><input id="edit_email" name="email" type="email" class="form-control" required></div>
                {{-- 🛠️ FIX EDIT MODAL: Option 'siswa' ditambahkan dan teks 'staff' diganti 'Guru' secara konsisten --}}
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-uppercase">Role</label>
                    <select id="edit_role" name="role" class="form-select" required>
                        <option value="admin">Administrator</option>
                        <option value="staff">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_active">
                        <label class="form-check-label text-white fw-bold">Status Aktif</label>
                    </div>
                </div>
                <div class="col-12 mt-3 p-3 rounded bg-dark border border-warning">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="reset_password" id="reset_pwd">
                        <label class="form-check-label text-warning fw-bold" for="reset_pwd">
                            RESET PASSWORD & TAMPILKAN AKSES BARU
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1">Gunakan fitur ini jika user lupa password.</small>
                </div>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="submit" class="btn btn-emerald w-100 fw-bold py-2">UPDATE DATA</button>
            </div>
        </form>
    </div>
</div>
@endsection