<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{
    /* ──────── BERANDA ──────── */
    public function index()
    {
        $room = Room::paginate(3);
        return view('index', compact('room'));
    }


    /* ──────── HALAMAN FORM PESAN (jika ada) ──────── */
    public function pesan()
    {
        $uri = Route::currentRouteName();
        return view('pesan', compact('uri'));
    }

    /* ──────── DAFTAR KAMAR (GET) ──────── */
    public function room(Request $request)
    {
        [$rooms, $roomsCount] = $this->fetchRooms($request);

        // data untuk kalender
        $bookings = $this->getCalendarBookings();
        
        $bookedDates = Transaction::bookedDates();

        return view('frontend.rooms', compact(
            'rooms',
            'roomsCount',
            'request',
            'bookings',
            'bookedDates'          // ← wajib ada
        ));
    }

    /* ──────── DAFTAR KAMAR (POST) ────────
       Kalau masih ada form POST ke /rooms, arahkan ke logika yang sama
    ─────────────────────────────────────── */
    public function roompost(Request $request)
    {
        return $this->room($request);
    }

    /* ──────── STATIC PAGE ──────── */
    public function facility() { return view('frontend.facilities'); }
    public function contact()  { return view('frontend.contact');   }

    public function about()
    {
        return view('frontend.about', [
            'r' => Room::count(),
            'c' => Customer::count(),
            't' => Transaction::count(),
        ]);
    }

    /* ==============================================================
       HELPER
       ============================================================== */

    /** Ambil list kamar + jumlah total sesuai filter */
    private function fetchRooms(Request $request): array
    {
        // Jika user mengisi filter
        if ($request->filled('from') || $request->filled('count')) {

            // kombinasi tanggal & kapasitas
            if ($request->filled(['from', 'to', 'count'])) {
                $occupied = $this->getOccupiedRoomID($request->from, $request->to);
                $query    = $this->queryRooms($request->count, $occupied);

            // hanya kapasitas
            } elseif ($request->filled('count')) {
                $query = $this->queryRooms($request->count);

            // hanya tanggal
            } else {
                $occupied = $this->getOccupiedRoomID($request->from, $request->to);
                $query    = $this->queryRooms(null, $occupied);
            }

            $rooms      = $query->paginate(10);
            $roomsCount = $query->count();

        } else {
            // tanpa filter apa pun
            $rooms      = Room::paginate(20);
            $roomsCount = Room::count();
        }

        return [$rooms, $roomsCount];
    }

    /** Query dasar kamar */
    private function queryRooms(?int $minCapacity = null, $excludeIds = null)
    {
        $q = Room::with('type', 'status');

        if ($excludeIds) {
            $q->whereNotIn('id', $excludeIds);
        }
        if (!is_null($minCapacity)) {
            $q->where('capacity', '>=', $minCapacity);
        }

        return $q->orderBy('capacity');
    }

    /** Ambil data transaksi untuk kalender */
    private function getCalendarBookings()
    {
        return Transaction::whereIn('status', ['Reservation', 'Paid']) // sesuaikan status
                ->selectRaw('check_in AS `from`, DATE_ADD(check_out, INTERVAL 1 DAY) AS `to`')
                ->get();
    }

    /** Dapatkan ID kamar yang terisi pada rentang tanggal */
    private function getOccupiedRoomID($stayfrom, $stayto)
    {
        return Transaction::where(function ($q) use ($stayfrom, $stayto) {
                $q->whereBetween('check_in',  [$stayfrom, $stayto])
                  ->orWhereBetween('check_out', [$stayfrom, $stayto])
                  ->orWhere(function ($q) use ($stayfrom, $stayto) {
                      $q->where('check_in',  '<=', $stayfrom)
                        ->where('check_out', '>=', $stayto);
                  });
            })->pluck('room_id');
    }
}
