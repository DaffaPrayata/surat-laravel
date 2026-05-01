@extends('layout.main')

@push('style')
<style>
    /* Styling Dasar Industrial */
    .card { border: 1px solid #2d2d2d; background: #1a1a1a; }
    .table thead { background-color: #252525; }
    .table thead th { color: #fff !important; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border: none; }
    .table td { color: #b0b0b0; border-color: #2d2d2d; }

    /* Mobile Card Style */
    .mobile-card {
        background: #1a1a1a;
        border: 1px solid #2d2d2d;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: 0.3s ease;
    }
    .mobile-card:hover { border-color: #10b981; }
    .data-label { font-size: 0.65rem; color: #6c757d; text-transform: uppercase; font-weight: 800; display: block; margin-bottom: 2px; }
    .value-text { color: #fff; font-weight: 500; font-size: 0.9rem; }

    /* Switch View Logic */
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
            $('#editModal form').attr('action', '{{ route('reference.classification.index') }}/' + id);
            $('#editModal input:hidden#id').val(id);
            $('#editModal input#code').val($(this).data('code'));
            $('#editModal input#type').val($(this).data('type'));
            $('#editModal input#description').val($(this).data('description'));
        });
    </script>
@endpush

@section('content')
    <x-breadcrumb :values="[__('menu.reference.menu'), __('menu.reference.classification')]">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bx bx-plus me-1"></i> {{ __('menu.general.create') }}
        </button>
    </x-breadcrumb>

    <div class="card desktop-view border-0 shadow-none">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover m-0">
                <thead>
                    <tr>
                        <th width="15%">{{ __('model.classification.code') }}</th>
                        <th width="20%">{{ __('model.classification.type') }}</th>
                        <th>{{ __('model.classification.description') }}</th>
                        <th width="10%" class="text-center">{{ __('menu.general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $classification)
                        <tr>
                            <td><span class="badge bg-label-primary fw-bold">{{ $classification->code }}</span></td>
                            <td class="text-white">{{ $classification->type }}</td>
                            <td><span class="small">{{ $classification->description }}</span></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded fs-5 text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                        <button class="dropdown-item btn-edit" 
                                            data-id="{{ $classification->id }}" 
                                            data-code="{{ $classification->code }}" 
                                            data-type="{{ $classification->type }}" 
                                            data-description="{{ $classification->description }}"
                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                            <i class="bx bx-edit-alt me-2 text-info"></i> Edit
                                        </button>
                                        <form action="{{ route('reference.classification.destroy', $classification) }}" method="post" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="dropdown-item btn-delete text-danger">
                                                <i class="bx bx-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">{{ __('menu.general.empty') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mobile-view">
        @forelse($data as $classification)
            <div class="mobile-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-primary px-3">{{ $classification->code }}</span>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded fs-4 text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                            <button class="dropdown-item btn-edit" data-id="{{ $classification->id }}" data-code="{{ $classification->code }}" data-type="{{ $classification->type }}" data-description="{{ $classification->description }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <form action="{{ route('reference.classification.destroy', $classification) }}" method="post">@csrf @method('DELETE') <button type="button" class="dropdown-item btn-delete text-danger">Hapus</button></form>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="data-label">Kategori</span>
                    <span class="value-text text-capitalize">{{ $classification->type }}</span>
                </div>
                <div>
                    <span class="data-label">Keterangan</span>
                    <p class="m-0 text-muted small lh-1.4">{{ $classification->description }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted bg-dark rounded border border-secondary">{{ __('menu.general.empty') }}</div>
        @endforelse
    </div>

    <div class="mt-4">
        {!! $data->appends(['search' => $search])->links() !!}
    </div>

    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content bg-dark border-secondary" method="post" action="{{ route('reference.classification.store') }}">
                @csrf
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title text-white">Buat Klasifikasi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <x-input-form name="code" :label="__('model.classification.code')"/>
                    <x-input-form name="type" :label="__('model.classification.type')"/>
                    <x-input-form name="description" :label="__('model.classification.description')"/>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content bg-dark border-secondary" method="post" action="">
                @csrf @method('PUT')
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title text-white">Update Klasifikasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <x-input-form name="code" :label="__('model.classification.code')"/>
                    <x-input-form name="type" :label="__('model.classification.type')"/>
                    <x-input-form name="description" :label="__('model.classification.description')"/>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection