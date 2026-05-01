@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter'), __('menu.general.view')]">
    </x-breadcrumb>

    <x-letter-card :letter="$data">
        <div class="mt-2">
            {{-- Header Section: Mirroring the Sidebar Header Style --}}
            <div class="d-flex align-items-center mb-4 pb-2" style="border-bottom: 1px dashed rgba(16, 185, 129, 0.2);">
                <div class="me-3 p-2 rounded-3" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="bx bx-envelope-open text-success fs-3"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="font-family: 'Syne', sans-serif; letter-spacing: -0.02em;">Detail Informasi Surat</h5>
                    <small class="text-muted" style="font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 0.1em; text-uppercase;">{{ __('menu.general.view') }}</small>
                </div>
            </div>

            {{-- Info Content --}}
            <div class="row g-4">
                {{-- Kiri: Identitas Surat --}}
                <div class="col-md-6">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(100, 116, 139, 0.05); border-left: 3px solid #10b981;">
                        <h6 class="mb-3 text-uppercase small fw-bold text-muted" style="font-family: 'DM Mono', monospace;">Identitas Utama</h6>
                        
                        <div class="mb-3">
                            <label class="d-block small text-muted">Nomor Surat</label>
                            <span class="fw-bold fs-5 text-emerald" style="color: #10b981;">{{ $data->reference_number }}</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <label class="d-block small text-muted">Nomor Agenda</label>
                                <span class="fw-medium text-dark">#{{ $data->agenda_number }}</span>
                            </div>
                            <div class="col-6">
                                <label class="d-block small text-muted">Asal Surat</label>
                                <span class="fw-medium text-dark text-uppercase">{{ $data->from }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Klasifikasi & Status --}}
                <div class="col-md-6">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(100, 116, 139, 0.05); border-left: 3px solid #64748b;">
                        <h6 class="mb-3 text-uppercase small fw-bold text-muted" style="font-family: 'DM Mono', monospace;">Klasifikasi & Arsip</h6>
                        
                        <div class="mb-3">
                            <label class="d-block small text-muted">Kode Klasifikasi</label>
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3);">
                                {{ $data->classification_code }}
                            </span>
                        </div>

                        <div>
                            <label class="d-block small text-muted">Tipe / Keterangan</label>
                            <span class="fw-medium">{{ $data->classification?->type ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Timeline Dates --}}
                <div class="col-12">
                    <div class="py-3 px-4 rounded-3 d-flex justify-content-between align-items-center flex-wrap gap-3" 
                         style="background: rgba(16, 185, 129, 0.03); border: 1px solid rgba(16, 185, 129, 0.1);">
                        
                        <div class="d-flex align-items-center">
                            <i class="bx bx-calendar-event me-2 text-muted"></i>
                            <div>
                                <small class="d-block text-muted" style="font-size: 10px;">TANGGAL SURAT</small>
                                <span class="fw-bold small">{{ $data->formatted_letter_date }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <i class="bx bx-down-arrow-circle me-2 text-success"></i>
                            <div>
                                <small class="d-block text-muted" style="font-size: 10px;">TANGGAL DITERIMA</small>
                                <span class="fw-bold small text-success">{{ $data->formatted_received_date }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center border-start ps-3">
                            <i class="bx bx-user me-2 text-muted"></i>
                            <div>
                                <small class="d-block text-muted" style="font-size: 10px;">INPUT OLEH</small>
                                <span class="fw-bold small">{{ $data->user?->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Meta --}}
            <div class="mt-4 pt-2 d-flex justify-content-between align-items-center opacity-50" style="font-family: 'DM Mono', monospace; font-size: 10px;">
                <span>Created: {{ $data->formatted_created_at }}</span>
                <span>Last Updated: {{ $data->formatted_updated_at }}</span>
            </div>
        </div>
    </x-letter-card>

    <style>
        /* Sesuaiin dikit biar matching ama sidebar lu */
        .text-emerald { color: #10b981 !important; }
        .bg-emerald-dim { background-color: rgba(16, 185, 129, 0.1); }
        
        /* Tambahin font DM Sans biar konsisten ama menu-link sidebar */
        dd, span, label {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
@endsection