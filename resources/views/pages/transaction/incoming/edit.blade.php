@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter'), __('menu.general.edit')]">
    </x-breadcrumb>

    <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto"> {{-- Bikin form gak terlalu lebar biar enak dibaca --}}
            <div class="card shadow-sm border-0">
                {{-- Header dengan garis hijau solid di atas --}}
                <div style="height: 4px; background: #10b981; border-radius: 8px 8px 0 0;"></div>
                
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-edit-alt fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Edit Surat Masuk</h5>
                            <small class="text-muted">Perbarui informasi data surat masuk</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('transaction.incoming.update', $data) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body border-top">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <input type="hidden" name="type" value="{{ $data->type }}">
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <x-input-form :value="$data->reference_number" name="reference_number"
                                              :label="__('model.letter.reference_number')"/>
                            </div>
                            <div class="col-md-6">
                                <x-input-form :value="$data->from" name="from" :label="__('model.letter.from')"/>
                            </div>
                            <div class="col-md-6">
                                <x-input-form :value="$data->agenda_number" name="agenda_number"
                                              :label="__('model.letter.agenda_number')"/>
                            </div>
                            <div class="col-md-6">
                                <x-input-form :value="date('Y-m-d', strtotime($data->letter_date))" name="letter_date" :label="__('model.letter.letter_date')"
                                              type="date"/>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="classification_code" class="form-label fw-bold small">
                                        {{ __('model.letter.classification_code') }}
                                    </label>
                                    <select class="form-select select2-emerald" id="classification_code" name="classification_code">
                                        @foreach($classifications as $classification)
                                            <option @selected(old('classification_code', $data->classification_code) == $classification->code)
                                                value="{{ $classification->code }}">
                                                [{{ $classification->code }}] - {{ $classification->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <x-input-textarea-form :value="$data->description" name="description"
                                                       :label="__('model.letter.description')"/>
                            </div>
                            
                            <div class="col-12">
                                <x-input-form :value="$data->note ?? ''" name="note" :label="__('model.letter.note')"/>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3">
                        <a href="{{ route('transaction.incoming.index') }}" class="btn btn-label-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Kembali
                        </a>
                        <button class="btn btn-success px-4 fw-bold" type="submit" style="background-color: #10b981 !important; border: none;">
                            <i class="bx bx-check-double me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Standar Form Styling */
        .form-label {
            color: #4b4b4b;
            margin-bottom: 0.5rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
        }
        .btn-label-secondary {
            color: #8592a3;
            border-color: transparent;
            background: rgba(133, 146, 163, 0.16);
        }
        .btn-label-secondary:hover {
            background: rgba(133, 146, 163, 0.25);
        }
    </style>
@endsection