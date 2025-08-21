<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        /* ────────────────────────
         | 1. Akses & pembatasan  |
         ────────────────────────*/
        if (auth()->guest()) {
            return redirect('/login');
        }
        if (auth()->user()->is_admin == 0) {
            abort(404);
        }

        /* ────────────────────────
         | 2. Data pembayaran DP  |
         ────────────────────────*/
        $payments    = Payment::where('status', 'Down Payment')->get();
        $totalAmount = $payments->sum('price');

        /* ───────────────────────────────
         | 3. Inisialisasi 12 bulan (0) |
         ───────────────────────────────*/
        $allMonths = collect(range(1, 12))
            ->mapWithKeys(fn ($m) => [
                Carbon::create()->month($m)->format('M') => 0
            ])
            ->all();                         // ['Jan'=>0, ..., 'Dec'=>0]

        $count  = $qty = $allMonths;
        $months = array_keys($allMonths);     // untuk grafik label

        /* ─────────────────────────
         | 4. Hitung per‑bulan     |
         ─────────────────────────*/
        $paymentsPerMonth = $payments->groupBy(
            fn ($p) => Carbon::parse($p->created_at)->format('M')
        );

        foreach ($paymentsPerMonth as $month => $group) {
            $count[$month] = $group->sum('price');
            $qty[$month]   = $group->count();
        }

        /* ───────────────────────────────
         | 5. Angka bulan sekarang & prev |
         ───────────────────────────────*/
        $currentMonth       = Carbon::now()->format('M');           // ex: 'Jun'
        $previousMonth      = Carbon::now()->subMonth()->format('M');
        $monthCount         = $count[$currentMonth]  ?? 0;
        $countPreviousMonth = $count[$previousMonth] ?? 0;

        /* ──────────────────────
         | 6. Persentase growth |
         ──────────────────────*/
        $percentage = $countPreviousMonth > 0
            ? ($monthCount / $countPreviousMonth) * 100
            : 0;

        /* ─────────────────────────────
         | 7. Konversi ke bar progress |
         ─────────────────────────────*/
        [$kiri, $kanan] = [0, 0];
        if ($percentage > 100) {
            $kiri  = 100 / $percentage * 100;
            $kanan = ($percentage - 100) / $percentage * 100;
        }

        /* ───────────────────────
         | 8. Tambahan statistik |
         ───────────────────────*/
        $transactionCount = Transaction::where('status', 'Reservation')->count();

        /* ─────────────────
         | 9. Kirim ke view |
         ─────────────────*/
        return view('dashboard.index', compact(
            'transactionCount', 'kiri', 'kanan',
            'qty', 'totalAmount', 'months',
            'count', 'monthCount', 'percentage'
        ));
    }

    /* ============================================================
       Sisa method tetap seperti sebelumnya
       ============================================================*/

    public function notifiable(Request $request)
    {
        if (auth()->guest()) {
            return redirect('/login');
        }
        if (auth()->user()->is_admin == 0) {
            abort(404);
        }

        // Logika lain jika diperlukan
        return redirect('/dashboard/order');
    }

    public function markall()
    {
        $notif = Notifications::where('status', 'unread')->get();
        foreach ($notif as $n) {
            $n->status   = 'read';
            $n->read_at  = Carbon::now();
            $n->save();
        }

        Alert::success('Success', 'Semua notifikasi ditandai terbaca!');
        return redirect('/dashboard/order');
    }
}
