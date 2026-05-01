@extends('layout.main')

@push('style')
<style>
    /* Emerald Dark Theme Custom */
    .card { background: #1a1a1a !important; border: 1px solid #2d2d2d !important; color: #f8fafc !important; border-radius: 12px; }
    .table { color: #cbd5e1 !important; }
    .table thead th { background-color: #252525 !important; color: #10b981 !important; border: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
    .table td { border-bottom: 1px solid #2d2d2d !important; }
    .table-hover tbody tr:hover { background-color: rgba(16, 185, 129, 0.05) !important; }

    .form-label { color: #94a3b8 !important; font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px; }
    .form-control, .form-select { background: #0f172a !important; border: 1px solid #334155 !important; color: #fff !important; }
    .form-control:focus, .form-select:focus { border-color: #10b981 !important; box-shadow: none !important; }

    .btn-emerald { background: #10b981 !important; color: white !important; border: none; transition: 0.3s; }
    .btn-emerald:hover { background: #059669 !important; transform: translateY(-1px); }
    
    .btn-outline-emerald { border: 1px solid #10b981 !important; color: #10b981 !important; background: transparent; }
    .btn-outline-emerald:hover { background: #10b981 !important; color: #fff !important; }

    /* Mobile Card Style */
    .mobile-card {
        background: #1a1a1a;
        border: 1px solid #2d2d2d;
        border-radius: 12px;
        margin-bottom: 1rem;
        padding: 15px;
        transition: 0.3s ease;
    }
    .mobile-card:hover { border-color: #10b981; }
    .data-label { font-size: 0.65rem; color: #6c757d; text-transform: uppercase; font-weight: 800; display: block; margin-bottom: 2px; }
    .value-text { color: #fff; font-weight: 500; font-size: 0.9rem; }

    /* Responsive View Logic */
    @media (max-width: 767.98px) {
        .desktop-view { display: none; }
        .mobile-view { display: block; }
        .filter-header { padding: 1rem !important; }
    }
    @media (min-width: 768px) {
        .desktop-view { display: block; }
        .mobile-view { display: none; }
    }
</style>
@endpush

@section('content')
    <x-breadcrumb :values="['Agenda', 'Surat Masuk']"></x-breadcrumb>

    <div class="card mb-4 shadow-lg border-0">
        <div class="card-header filter-header pt-4">
            <h5 class="text-white fw-bold mb-4"><i class="bx bx-filter-alt me-2 text-success"></i>Filter Agenda</h5>
            
            <form action="{{ url()->current() }}">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <div class="row g-3 align-items-end">
                    <div class="col-6 col-md-3">
                        <label class="form-label text-uppercase">Dari Tanggal</label>
                        <input type="date" name="since" class="form-control" 
                               value="{{ $since ? date('Y-m-d', strtotime($since)) : '' }}">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-uppercase">Sampai Tanggal</label>
                        <input type="date" name="until" class="form-control" 
                               value="{{ $until ? date('Y-m-d', strtotime($until)) : '' }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="filter" class="form-label text-uppercase">Berdasarkan</label>
                        <select class="select2 form-select" id="filter" name="filter">
                            <option value="letter_date" @selected(old('filter', $filter) == 'letter_date')>Tanggal Surat</option>
                            <option value="received_date" @selected(old('filter', $filter) == 'received_date')>Tanggal Diterima</option>
                            <option value="created_at" @selected(old('filter', $filter) == 'created_at')>Tanggal Entri</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex gap-2">
                            <button class="btn btn-emerald flex-grow-1" type="submit">
                                <i class="bx bx-search-alt me-1"></i> Filter
                            </button>
                            <a href="{{ route('agenda.incoming.print') . '?' . $query }}" 
                               target="_blank" class="btn btn-outline-emerald">
                                <i class="bx bx-printer"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card desktop-view border-0 shadow-none">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle m-0">
                <thead>
                    <tr>
                        <th class="ps-4">No. Agenda</th>
                        <th>Nomor Surat</th>
                        <th>Asal Surat</th>
                        <th>Tgl. Surat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $agenda)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-label-success fw-bold px-3">{{ $agenda->agenda_number }}</span>
                            </td>
                            <td>
                                <a href="{{ route('transaction.incoming.show', $agenda) }}" class="text-info fw-bold">
                                    {{ $agenda->reference_number }}
                                </a>
                            </td>
                            <td class="text-white">{{ $agenda->from }}</td>
                            <td><i class="bx bx-calendar me-1 text-success"></i>{{ $agenda->formatted_letter_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bx bx-folder-open fs-1 d-block mb-2 text-muted"></i>
                                <span class="text-muted">Data tidak ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mobile-view">
        @forelse($data as $agenda)
            <div class="mobile-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                    <span class="badge bg-label-success fw-bold">No. Agenda: {{ $agenda->agenda_number }}</span>
                    <a href="{{ route('transaction.incoming.show', $agenda) }}" class="btn btn-sm btn-outline-info">
                        <i class="bx bx-show"></i>
                    </a>
                </div>
                <div class="mb-2">
                    <span class="data-label">Nomor Surat</span>
                    <span class="value-text text-info fw-bold">{{ $agenda->reference_number }}</span>
                </div>
                <div class="mb-2">
                    <span class="data-label">Asal Surat</span>
                    <span class="value-text">{{ $agenda->from }}</span>
                </div>
                <div>
                    <span class="data-label">Tanggal Surat</span>
                    <span class="value-text"><i class="bx bx-calendar me-1 text-success small"></i>{{ $agenda->formatted_letter_date }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted bg-dark rounded border border-secondary">
                <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
                Data agenda kosong.
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {!! $data->appends(['search' => $search, 'since' => $since, 'until' => $until, 'filter' => $filter])->links() !!}
    </div>
@endsection