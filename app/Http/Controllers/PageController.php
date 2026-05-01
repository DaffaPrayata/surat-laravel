<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Helpers\GeneralHelper;
use App\Http\Requests\UpdateConfigRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Attachment;
use App\Models\Config;
use App\Models\Disposition;
use App\Models\Letter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Dashboard — statistik, grafik 6 bulan, & aktivitas terbaru
     */
    public function index(Request $request): View
    {
        // ── 1. STATISTIK HARI INI ──────────────────────────────────
        $todayIncomingLetter     = Letter::incoming()->today()->count();
        $todayOutgoingLetter     = Letter::outgoing()->today()->count();
        $todayDispositionLetter  = Disposition::today()->count();
        $todayLetterTransaction  = $todayIncomingLetter + $todayOutgoingLetter + $todayDispositionLetter;

        // ── 2. STATISTIK KEMARIN (untuk % perubahan) ───────────────
        $yesterdayIncomingLetter    = Letter::incoming()->yesterday()->count();
        $yesterdayOutgoingLetter    = Letter::outgoing()->yesterday()->count();
        $yesterdayDispositionLetter = Disposition::yesterday()->count();
        $yesterdayLetterTransaction = $yesterdayIncomingLetter
                                    + $yesterdayOutgoingLetter
                                    + $yesterdayDispositionLetter;

        // ── 3. AUTO-NUMBER AGENDA ──────────────────────────────────
        $nextIncoming = ((int) Letter::incoming()->max('agenda_number')) + 1;
        $nextOutgoing = ((int) Letter::outgoing()->max('agenda_number')) + 1;

        // ── 4. DATA GRAFIK — 6 Bulan Terakhir ─────────────────────
        $months          = [];
        $incomingMonthly = [];
        $outgoingMonthly = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);

            $months[] = $month->translatedFormat('M'); // Jan, Feb, ...

            $incomingMonthly[] = Letter::incoming()
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $outgoingMonthly[] = Letter::outgoing()
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        // ── 5. RECENT LETTERS untuk Mobile Activity Log ────────────
        //
        // Kita ambil 5 surat terbaru (incoming + outgoing) digabung
        // via UNION, lalu tambahkan field `letter_type` yang eksplisit
        // agar Blade bisa pakai $letter->letter_type tanpa ambiguitas.
        //
        // Catatan: sesuaikan nama kolom (letter_number, from, to)
        // dengan skema tabel `letters` di project lu.
        //
        $recentLetters = Letter::with(['classification', 'user'])
            ->select([
                'id',
                'reference_number',
                'type',   // kolom ENUM: 'incoming' | 'outgoing'
                'from',          // pengirim (surat masuk)
                'to',            // penerima (surat keluar)
                'created_at',
            ])
            ->latest()
            ->take(5)
            ->get();

        // ── 6. RETURN VIEW ─────────────────────────────────────────
        return view('pages.dashboard', [
            // Sapaan & tanggal
            'greeting'    => GeneralHelper::greeting(),
            'currentDate' => Carbon::now()->isoFormat('dddd, D MMMM YYYY'),

            // Statistik hari ini
            'todayIncomingLetter'    => $todayIncomingLetter,
            'todayOutgoingLetter'    => $todayOutgoingLetter,
            'todayDispositionLetter' => $todayDispositionLetter,
            'todayLetterTransaction' => $todayLetterTransaction,

            // Pengguna aktif
            'activeUser' => User::active()->count(),

            // Persentase perubahan vs kemarin
            'percentageIncomingLetter'    => GeneralHelper::calculateChangePercentage(
                $yesterdayIncomingLetter, $todayIncomingLetter
            ),
            'percentageOutgoingLetter'    => GeneralHelper::calculateChangePercentage(
                $yesterdayOutgoingLetter, $todayOutgoingLetter
            ),
            'percentageDispositionLetter' => GeneralHelper::calculateChangePercentage(
                $yesterdayDispositionLetter, $todayDispositionLetter
            ),
            'percentageLetterTransaction' => GeneralHelper::calculateChangePercentage(
                $yesterdayLetterTransaction, $todayLetterTransaction
            ),

            // Auto-number
            'nextIncoming' => $nextIncoming,
            'nextOutgoing' => $nextOutgoing,

            // Grafik 6 bulan
            'chartMonths'   => json_encode($months),
            'chartIncoming' => json_encode($incomingMonthly),
            'chartOutgoing' => json_encode($outgoingMonthly),

            // Mobile activity log
            'recentLetters' => $recentLetters,
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    //  Method lain — TIDAK DIUBAH, disalin apa adanya
    // ═══════════════════════════════════════════════════════════

    public function profile(Request $request): View
    {
        return view('pages.profile', [
            'data' => auth()->user(),
        ]);
    }

    public function profileUpdate(UpdateUserRequest $request): RedirectResponse
    {
        try {
            $newProfile = $request->validated();
            if ($request->hasFile('profile_picture')) {
                $oldPicture = auth()->user()->profile_picture;
                if (str_contains($oldPicture, '/storage/avatars/')) {
                    $url = parse_url($oldPicture, PHP_URL_PATH);
                    Storage::delete(str_replace('/storage', 'public', $url));
                }
                $filename = time()
                    . '-' . $request->file('profile_picture')->getFilename()
                    . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                $request->file('profile_picture')->storeAs('public/avatars', $filename);
                $newProfile['profile_picture'] = asset('storage/avatars/' . $filename);
            }
            auth()->user()->update($newProfile);
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function deactivate(): RedirectResponse
    {
        try {
            auth()->user()->update(['is_active' => false]);
            Auth::logout();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function settings(Request $request): View
    {
        return view('pages.setting', [
            'configs' => Config::all(),
        ]);
    }

    public function settingsUpdate(UpdateConfigRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            foreach ($request->validated() as $code => $value) {
                Config::where('code', $code)->update(['value' => $value]);
            }
            DB::commit();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function removeAttachment(Request $request): RedirectResponse
    {
        try {
            $attachment = Attachment::find($request->id);
            if (!$attachment) return back()->with('error', 'File tidak ditemukan');

            $oldPicture = $attachment->path_url;
            if (str_contains($oldPicture, '/storage/attachments/')) {
                $url = parse_url($oldPicture, PHP_URL_PATH);
                Storage::delete(str_replace('/storage', 'public', $url));
            }
            $attachment->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}