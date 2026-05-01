<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Models\Attachment;
use App\Models\Classification;
use App\Models\Config;
use App\Models\Letter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class IncomingLetterController extends Controller
{
    /**
     * Tampilan List Surat Masuk
     */
    public function index(Request $request): View
    {
        // Mengecek permission viewAny di LetterPolicy
        $this->authorize('viewAny', Letter::class);
        
        return view('pages.transaction.incoming.index', [
            'data' => Letter::incoming()->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Tampilan Halaman Agenda (Filter & Laporan)
     */
    public function agenda(Request $request): View
    {
        $this->authorize('viewAny', Letter::class);

        return view('pages.transaction.incoming.agenda', [
            'data' => Letter::incoming()->agenda($request->since, $request->until, $request->filter)->render($request->search),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'query' => $request->getQueryString(),
        ]);
    }

    /**
     * Fungsi Print Laporan
     */
    public function print(Request $request): View
    {
        // Cuma Admin/Staff yang biasanya boleh cetak laporan agenda
        $this->authorize('create', Letter::class);

        $since = $request->since ?? now()->subDays(7)->format('Y-m-d');
        $until = $request->until ?? now()->format('Y-m-d');
        $filter = $request->filter ?? 'letter_date';

        $configData = Config::pluck('value', 'code');

        return view('pages.transaction.incoming.print', [
            'data' => Letter::incoming()->agenda($since, $until, $filter)->get(),
            'search' => $request->search,
            'since' => Carbon::parse($since)->format('d/m/Y'),
            'until' => Carbon::parse($until)->format('d/m/Y'),
            'filter' => $filter,
            'config' => [
                'institution_name' => $configData['institution_name'] ?? 'SMK NEGERI 2 PADANG',
                'institution_address' => $configData['institution_address'] ?? 'Jl. Jati No.5, Padang',
            ],
            'title' => __('menu.agenda.menu') . ' ' . __('menu.agenda.incoming_letter'),
        ]);
    }

    /**
     * Form Tambah Surat
     */
    public function create(): View
    {
        // Policy ini sekarang izinin Admin, Staff, dan Siswa
        $this->authorize('create', Letter::class);

        $maxAgenda = Letter::incoming()->max('agenda_number');
        $nextAgenda = ((int) $maxAgenda) + 1;

        return view('pages.transaction.incoming.create', [
            'classifications' => Classification::all(),
            'nextAgenda' => $nextAgenda,
        ]);
    }

    /**
     * Simpan Data Surat
     */
    public function store(StoreLetterRequest $request): RedirectResponse
    {
        $this->authorize('create', Letter::class);

        try {
            $user = auth()->user();

            // Pastikan input type ada di request
            if ($request->type != LetterType::INCOMING->type()) {
                throw new \Exception("Tipe surat tidak valid!");
            }
            
            $newLetter = $request->all();
            $newLetter['user_id'] = $user->id; // ID Pembuat surat
            
            // Simpan ke database
            $letter = Letter::create($newLetter);

            // Handle lampiran jika ada
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    
                    $filename = time() . '-'. str_replace(' ', '-', $attachment->getClientOriginalName());
                    $attachment->storeAs('public/attachments', $filename);
                    
                    Attachment::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => $user->id,
                        'letter_id' => $letter->id,
                    ]);
                }
            }

            return redirect()
                ->route('transaction.incoming.index')
                ->with('success', __('menu.general.success'));

        } catch (\Throwable $exception) {
            // Jika gagal, kembali ke form dengan pesan error
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Detail Surat
     */
    public function show(Letter $incoming): View
    {
        // Siswa cuma bisa liat kalau namanya ada di kolom 'to'
        $this->authorize('view', $incoming);

        return view('pages.transaction.incoming.show', [
            'data' => $incoming->load(['classification', 'user', 'attachments']),
        ]);
    }

    /**
     * Form Edit Surat
     */
    public function edit(Letter $incoming): View
    {
        // Cuma Admin & Staff yang boleh edit
        $this->authorize('update', $incoming);

        return view('pages.transaction.incoming.edit', [
            'data' => $incoming,
            'classifications' => Classification::all(),
        ]);
    }

    /**
     * Update Data Surat
     */
    public function update(UpdateLetterRequest $request, Letter $incoming): RedirectResponse
    {
        $this->authorize('update', $incoming);

        try {
            $incoming->update($request->validated());
            
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    
                    $filename = time() . '-'. str_replace(' ', '-', $attachment->getClientOriginalName());
                    $attachment->storeAs('public/attachments', $filename);
                    
                    Attachment::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => auth()->id(),
                        'letter_id' => $incoming->id,
                    ]);
                }
            }
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Hapus Surat
     */
    public function destroy(Letter $incoming): RedirectResponse
    {
        // Cuma Admin yang boleh hapus
        $this->authorize('delete', $incoming);
        
        try {
            $incoming->delete();
            return redirect()
                ->route('transaction.incoming.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}