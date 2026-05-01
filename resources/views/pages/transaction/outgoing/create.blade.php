@extends('layout.main')

@push('style')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --green-dark:   #085041;
        --green-mid:    #0F6E56;
        --green-base:   #1D9E75;
        --green-light:  #E1F5EE;
        --red-base:     #E24B4A;
        --red-light:    #FCEBEB;
        --border:       rgba(0,0,0,.10);
        --border-focus: #1D9E75;
        --text:         #0f172a;
        --muted:        #64748b;
        --hint:         #94a3b8;
        --bg:           #f8fafc;
        --surface:      #ffffff;
        --mono:         'DM Mono', monospace;
        --sans:         'DM Sans', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        font-family: var(--sans);
        color: var(--text);
        -webkit-font-smoothing: antialiased;
    }

    /* ── PAGE WRAPPER ── */
    .sm-wrap {
        max-width: 680px;
        margin: 32px auto;
        padding: 0 16px 48px;
    }

    /* ── PAGE HEADER ── */
    .sm-header {
        margin-bottom: 28px;
    }
    .sm-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--mono);
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 10px;
    }
    .sm-badge::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--green-base);
        flex-shrink: 0;
    }
    .sm-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--text);
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .sm-subtitle {
        font-size: 13px;
        color: var(--muted);
    }

    /* ── CARD ── */
    .sm-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    /* ── SECTION inside card ── */
    .sm-section {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
    }
    .sm-section:last-child {
        border-bottom: none;
    }
    .sm-section-label {
        font-family: var(--mono);
        font-size: 10px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--hint);
        margin-bottom: 14px;
    }

    /* ── GRID ── */
    .sm-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* ── FIELD ── */
    .sm-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .sm-field.full {
        grid-column: 1 / -1;
    }
    .sm-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--muted);
        letter-spacing: .01em;
    }
    .sm-label .req {
        color: var(--red-base);
        margin-left: 2px;
    }
    .sm-hint {
        font-size: 11px;
        color: var(--hint);
        margin-top: 2px;
    }

    /* ── INPUTS ── */
    .sm-input,
    .sm-select,
    .sm-textarea {
        width: 100%;
        padding: 10px 12px;
        font-size: 14px;
        font-family: var(--sans);
        color: var(--text);
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 6px;
        outline: none;
        transition: border-color .15s, box-shadow .15s, background .15s;
        -webkit-appearance: none;
        appearance: none;
    }
    .sm-select {
        background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2394a3b8' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }
    .sm-textarea {
        resize: vertical;
        min-height: 84px;
        line-height: 1.55;
    }
    .sm-input:focus,
    .sm-select:focus,
    .sm-textarea:focus {
        border-color: var(--border-focus);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(29,158,117,.12);
    }
    .sm-input::placeholder,
    .sm-textarea::placeholder {
        color: var(--hint);
    }

    /* ── ERROR STATE ── */
    .sm-input.is-invalid,
    .sm-select.is-invalid,
    .sm-textarea.is-invalid {
        border-color: var(--red-base);
        box-shadow: 0 0 0 3px rgba(226,75,74,.10);
    }
    .sm-error-text {
        font-size: 11px;
        color: var(--red-base);
        margin-top: 3px;
    }

    /* ── ALERT ERRORS ── */
    .sm-alert {
        background: var(--red-light);
        border: 1px solid rgba(226,75,74,.25);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 20px;
    }
    .sm-alert-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--red-base);
        margin-bottom: 6px;
    }
    .sm-alert ul {
        padding-left: 16px;
        margin: 0;
    }
    .sm-alert li {
        font-size: 13px;
        color: #A32D2D;
        margin-bottom: 2px;
    }

    /* ── FOOTER / SUBMIT ── */
    .sm-footer {
        padding: 20px 24px;
        background: var(--bg);
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .sm-footer-note {
        font-size: 12px;
        color: var(--hint);
    }
    .sm-footer-note span {
        color: var(--red-base);
    }
    .sm-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: var(--green-mid);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        font-family: var(--sans);
        border: none;
        border-radius: 6px;
        cursor: pointer;
        letter-spacing: .01em;
        transition: background .15s, transform .1s;
        white-space: nowrap;
    }
    .sm-btn:hover  { background: var(--green-dark); }
    .sm-btn:active { transform: scale(.99); }
    .sm-btn svg    { width: 15px; height: 15px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* ── MOBILE ── */
    @media (max-width: 560px) {
        .sm-wrap      { margin: 16px auto; padding: 0 12px 40px; }
        .sm-title     { font-size: 20px; }
        .sm-section   { padding: 16px; }
        .sm-grid      { grid-template-columns: 1fr; }
        .sm-field.full{ grid-column: 1; }
        .sm-footer    { padding: 16px; flex-direction: column; align-items: stretch; }
        .sm-btn       { justify-content: center; width: 100%; }
    }
</style>
@endpush

@section('content')
@php
    $tingkatan = ['X', 'XI', 'XII'];
    $jurusan = [
        'AKL 1','AKL 2','AKL 3',
        'MPLB 1','MPLB 2',
        'BDR 1','BDR 2',
        'PPLG 1','PPLG 2',
        'TJKT 1','TJKT 2',
        'ULW 1',
    ];
@endphp

<div class="sm-wrap">

    {{-- PAGE HEADER --}}
    <div class="sm-header">
        <div class="sm-badge">Administrasi Surat</div>
        <h1 class="sm-title">Input Surat Keluar</h1>
        <p class="sm-subtitle">Isi seluruh kolom sesuai data surat yang dikirim.</p>
    </div>

    {{-- VALIDATION ERROR SUMMARY --}}
    @if ($errors->any())
        <div class="sm-alert">
            <div class="sm-alert-title">Terdapat {{ $errors->count() }} kesalahan pada form:</div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="sm-card">
        <form action="{{ route('transaction.outgoing.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="outgoing">

            {{-- SECTION 1: INFORMASI KELAS --}}
            <div class="sm-section">
                <div class="sm-section-label">Informasi Kelas</div>
                <div class="sm-grid">

                    {{-- JAM --}}
                    <div class="sm-field">
                        <label class="sm-label" for="reference_number">
                            Jam Pelajaran <span class="req">*</span>
                        </label>
                        <select
                            id="reference_number"
                            name="reference_number"
                            class="sm-select @error('reference_number') is-invalid @enderror"
                            required
                        >
                            <option disabled {{ old('reference_number') ? '' : 'selected' }}>Pilih jam</option>
                            @for ($i = 1; $i <= 11; $i++)
                                <option value="Jam ke-{{ $i }}" {{ old('reference_number') == "Jam ke-$i" ? 'selected' : '' }}>
                                    Jam ke-{{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('reference_number')
                            <span class="sm-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- KELAS --}}
                    <div class="sm-field">
                        <label class="sm-label" for="agenda_number">
                            Kelas <span class="req">*</span>
                        </label>
                        <select
                            id="agenda_number"
                            name="agenda_number"
                            class="sm-select @error('agenda_number') is-invalid @enderror"
                            required
                        >
                            <option disabled {{ old('agenda_number') ? '' : 'selected' }}>Pilih kelas</option>
                            @foreach($tingkatan as $t)
                                <optgroup label="Kelas {{ $t }}">
                                    @foreach($jurusan as $j)
                                        <option
                                            value="{{ $t }} {{ $j }}"
                                            {{ old('agenda_number') == "$t $j" ? 'selected' : '' }}
                                        >
                                            {{ $t }} {{ $j }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('agenda_number')
                            <span class="sm-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- SECTION 2: IDENTITAS SURAT --}}
            <div class="sm-section">
                <div class="sm-section-label">Identitas Surat</div>
                <div class="sm-grid">

                    {{-- KODE --}}
                    <div class="sm-field full">
                        <label class="sm-label" for="classification_code">
                            Kode Klasifikasi <span class="req">*</span>
                        </label>
                        <select
                            id="classification_code"
                            name="classification_code"
                            class="sm-select @error('classification_code') is-invalid @enderror"
                            required
                        >
                            <option disabled {{ old('classification_code') ? '' : 'selected' }}>Pilih kode</option>
                            @foreach($classifications as $classification)
                                <option
                                    value="{{ $classification->code }}"
                                    {{ old('classification_code') == $classification->code ? 'selected' : '' }}
                                >
                                    {{ $classification->code }} — {{ $classification->type }}
                                </option>
                            @endforeach
                        </select>
                        <span class="sm-hint">Kode sesuai buku klasifikasi arsip sekolah.</span>
                        @error('classification_code')
                            <span class="sm-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PENERIMA --}}
                    <div class="sm-field full">
                        <label class="sm-label" for="to">
                            {{ __('model.letter.to') }} <span class="req">*</span>
                        </label>
                        <input
                            id="to"
                            type="text"
                            name="to"
                            class="sm-input @error('to') is-invalid @enderror"
                            value="{{ old('to') }}"
                            placeholder="Nama Siswa/Guru/Instansi Penerima"
                            required
                        >
                        @error('to')
                            <span class="sm-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- SECTION 3: TANGGAL --}}
            <div class="sm-section">
                <div class="sm-section-label">Waktu</div>
                <div class="sm-grid">

                    {{-- TANGGAL SURAT --}}
                    <div class="sm-field">
                        <label class="sm-label" for="letter_date">
                            {{ __('model.letter.letter_date') }} <span class="req">*</span>
                        </label>
                        <input
                            id="letter_date"
                            type="date"
                            name="letter_date"
                            class="sm-input @error('letter_date') is-invalid @enderror"
                            value="{{ old('letter_date') }}"
                            required
                        >
                        @error('letter_date')
                            <span class="sm-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- TANGGAL DIKIRIM --}}
                    <div class="sm-field">
                        <label class="sm-label" for="sent_date">
                            {{ __('tangga diterima') }} <span class="req">*</span>
                        </label>
                        <input
                            id="sent_date"
                            type="date"
                            name="sent_date"
                            class="sm-input @error('sent_date') is-invalid @enderror"
                            value="{{ old('sent_date') }}"
                            required
                        >
                        @error('sent_date')
                            <span class="sm-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- SECTION 4: KETERANGAN --}}
            <div class="sm-section">
                <div class="sm-section-label">Keterangan</div>
                <div class="sm-field">
                    <label class="sm-label" for="description">
                        {{ __('model.letter.description') }}
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        class="sm-textarea @error('description') is-invalid @enderror"
                        placeholder="Tulis ringkasan isi / perihal surat..."
                    >{{ old('description') }}</textarea>
                    <span class="sm-hint">Opsional. Ringkas dalam 1–2 kalimat.</span>
                    @error('description')
                        <span class="sm-error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- FOOTER / SUBMIT --}}
            <div class="sm-footer">
                <span class="sm-footer-note"><span>*</span> Wajib diisi</span>
                <button type="submit" class="sm-btn">
                    <svg viewBox="0 0 16 16"><path d="M13.5 4.5 6 12 2.5 8.5"/></svg>
                    Simpan Surat Keluar
                </button>
            </div>

        </form>
    </div>

</div>
@endsection  