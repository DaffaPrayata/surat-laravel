{{-- Style Khusus Letter Card (Bisa ditaruh di sini atau dipindah ke file CSS utama) --}}
@once
@push('style')
<style>
    .letter-card-industrial {
        background: linear-gradient(145deg, #161616 0%, #0f0f0f 100%);
        border: 1px solid #2d2d2d;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .letter-card-industrial:hover {
        border-color: #10b981;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    }

    .card-header-industrial {
        background: rgba(255, 255, 255, 0.03);
        padding: 12px 16px;
        border-bottom: 1px solid #2d2d2d;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Badge styling */
    .type-badge {
        font-size: 9px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 50px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .type-badge.incoming { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
    .type-badge.outgoing { background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); }

    .value-highlight { 
        color: #ffffff; 
        font-size: 15px; 
        font-weight: 700; 
        line-height: 1.2;
        margin-top: 2px;
    }

    .data-group label { 
        display: block; 
        font-size: 9px; 
        font-weight: 700; 
        color: #555; 
        margin-bottom: 4px; 
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-subtext {
        color: #888;
        font-size: 11px;
        font-weight: 500;
    }

    .card-footer-custom {
        padding: 10px 16px;
        background: rgba(0,0,0,0.2);
        border-top: 1px solid #222;
    }

    /* Utilitas untuk teks panjang */
    .text-truncate-custom {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endonce

<div class="letter-card-industrial">
    <div class="card-header-industrial">
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="type-badge {{ $letter->type == 'incoming' ? 'incoming' : 'outgoing' }}">
                    {{ $letter->type == 'incoming' ? 'Masuk' : 'Keluar' }}
                </span>
                <span class="fw-bold" style="color: #facc15; font-family: 'JetBrains Mono', monospace; font-size: 11px;">
                    #{{ str_pad($letter->agenda_number ?? 0, 3, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            <div class="info-subtext text-truncate" style="max-width: 180px; font-family: monospace;">
                {{ $letter->reference_number }}
            </div>
        </div>
        
        <div class="dropdown">
            <button class="btn btn-link text-muted p-0 shadow-none" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded fs-4"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="{{ route('transaction.' . $letter->type . '.show', $letter->id) }}"><i class='bx bx-show me-2'></i> Detail</a></li>
                <li><a class="dropdown-item" href="{{ route('transaction.' . $letter->type . '.edit', $letter->id) }}"><i class='bx bx-edit-alt me-2'></i> Edit</a></li>
                <li><hr class="dropdown-divider border-secondary"></li>
                <li>
                    <form action="{{ route('transaction.' . $letter->type . '.destroy', $letter->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"><i class='bx bx-trash me-2'></i> Hapus</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="data-group mb-3">
            <label>
                <i class='bx {{ $letter->type == 'incoming' ? 'bx-log-in-circle' : 'bx-log-out-circle' }} me-1'></i>
                {{ $letter->type == 'incoming' ? 'Asal Surat' : 'Tujuan Surat' }}
            </label>
            <div class="value-highlight text-truncate-custom">
                {{ $letter->type == 'incoming' ? ($letter->from ?? 'N/A') : ($letter->to ?? 'N/A') }}
            </div>
        </div>

        <div class="row g-3">
            <div class="col-6">
                <div class="data-group">
                    <label>Tanggal</label>
                    <div class="info-subtext text-white-50">
                        <i class='bx bx-calendar-event me-1'></i>
                        {{ \Carbon\Carbon::parse($letter->letter_date)->isoFormat('D MMM YYYY') }}
                    </div>
                </div>
            </div>
            <div class="col-6 text-end">
                <div class="data-group">
                    <label>Klasifikasi</label>
                    <div class="info-subtext text-white-50">
                        <span class="badge bg-dark border border-secondary fw-normal">
                            {{ $letter->classification->code ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer-custom">
        <div class="data-group">
            <label>Perihal</label>
            <p class="m-0 text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                {{ $letter->description ?? 'Tidak ada keterangan perihal.' }}
            </p>
        </div>
    </div>
</div>