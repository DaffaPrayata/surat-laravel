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

class OutgoingLetterController extends Controller
{
    /**
     * Tampilan List Surat Keluar
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Letter::class);
        
        return view('pages.transaction.outgoing.index', [
            'data' => Letter::outgoing()->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Tampilan Halaman Agenda (Filter)
     */
    public function agenda(Request $request): View
    {
        return view('pages.transaction.outgoing.agenda', [
            'data' => Letter::outgoing()->agenda($request->since, $request->until, $request->filter)->render($request->search),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'query' => $request->getQueryString(),
        ]);
    }

    /**
     * Fungsi Print Laporan (Mingguan & Anti-Error)
     */
    public function print(Request $request): View
    {
        $since = $request->since ?? now()->subDays(7)->format('Y-m-d');
        $until = $request->until ?? now()->format('Y-m-d');
        $filter = $request->filter ?? 'letter_date';

        $agenda = __('menu.agenda.menu');
        $letter = __('menu.agenda.outgoing_letter');
        $title = App::getLocale() == 'id' ? "$agenda $letter" : "$letter $agenda";

        $configData = Config::pluck('value', 'code');

        return view('pages.transaction.outgoing.print', [
            'data' => Letter::outgoing()->agenda($since, $until, $filter)->get(),
            'search' => $request->search,
            'since' => \Carbon\Carbon::parse($since)->format('d/m/Y'),
            'until' => \Carbon\Carbon::parse($until)->format('d/m/Y'),
            'filter' => $filter,
            'config' => [
                'institution_name' => $configData['institution_name'] ?? 'SMK NEGERI 2 PADANG',
                'institution_address' => $configData['institution_address'] ?? 'Jl. Jati No.5, Padang',
            ],
            'title' => $title,
        ]);
    }

    /**
     * Form Tambah Surat
     */
    public function create(): View
    {
        $this->authorize('create', Letter::class);

        $maxAgenda = Letter::outgoing()->max('agenda_number');
        $nextAgenda = ((int) $maxAgenda) + 1;

        return view('pages.transaction.outgoing.create', [
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

            if ($request->type != LetterType::OUTGOING->type()) throw new \Exception(__('menu.transaction.outgoing_letter'));
            
            $newLetter = $request->all();
            $newLetter['user_id'] = $user->id;
            $letter = Letter::create($newLetter);

            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $attachment->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
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
                ->route('transaction.outgoing.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Detail Surat
     */
    public function show(Letter $outgoing): View
    {
        $this->authorize('view', $outgoing);

        return view('pages.transaction.outgoing.show', [
            'data' => $outgoing->load(['classification', 'user', 'attachments']),
        ]);
    }

    /**
     * Form Edit Surat
     */
    public function edit(Letter $outgoing): View
    {
        $this->authorize('update', $outgoing);

        return view('pages.transaction.outgoing.edit', [
            'data' => $outgoing,
            'classifications' => Classification::all(),
        ]);
    }

    /**
     * Update Data Surat
     */
    public function update(UpdateLetterRequest $request, Letter $outgoing): RedirectResponse
    {
        $this->authorize('update', $outgoing);

        try {
            $outgoing->update($request->validated());
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $attachment->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $attachment->storeAs('public/attachments', $filename);
                    Attachment::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => auth()->user()->id,
                        'letter_id' => $outgoing->id,
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
    public function destroy(Letter $outgoing): RedirectResponse
    {
        $this->authorize('delete', $outgoing);
        try {
            $outgoing->delete();
            return redirect()
                ->route('transaction.outgoing.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
