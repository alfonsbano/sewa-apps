<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // kolom tanggal otomatis diparsing ke Carbon
    protected $casts = [
        'check_in'  => 'datetime',
        'check_out' => 'datetime',
    ];

    /* =============================================================
     | HELPER: bookedDates()                                        |
     ============================================================= */
    /**
     * Dapatkan semua tanggal yang telah dibooking (status Reservation atau Paid)
     * dalam format collection berisi string 'Y-m-d'.
     * Menghasilkan tanggal inklusif check_in dan check_out (dengan check_out dieksklusikan
     * agar selaras dengan perilaku FullCalendar).
     */

     
public static function bookedDates()
{
    $transactions = self::whereIn('status', ['Reservation', 'Paid'])->get();

    $dates = [];

    foreach ($transactions as $trx) {
        $start = \Carbon\Carbon::parse($trx->check_in);
        $end   = \Carbon\Carbon::parse($trx->check_out);

        // Loop dari check_in sampai check_out (inklusif)
        while ($start <= $end) {
            $dates[] = $start->toDateString();
            $start->addDay();
        }
    }

    return $dates;
}


    // public static function bookedDates(): Collection
    // {
    //     return self::whereIn('status', ['Reservation', 'Paid'])
    //         ->get(['check_in', 'check_out'])
    //         ->flatMap(function ($row) {
    //             $period = CarbonPeriod::create(
    //                 Carbon::parse($row->check_in),
    //                 Carbon::parse($row->check_out)->subDay() // end exclusive
    //             );
    //             return collect($period)->map->format('Y-m-d');
    //         })
    //         ->unique()
    //         ->values();
    // }

    /* ==========
     | RELATIONS |
     ========== */
    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'c_id');
    }

    public function Room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'c_id');
    }

    /* =========================
     | ACCESSORS & CALCULATIONS |
     ========================= */

    /**
     * Durasi sewa inklusif.
     * Jika check‑in = check‑out → tetap 1 hari.
     */
    public function getDurationAttribute(): int
    {
        return $this->check_in->clone()->startOfDay()
            ->diffInDays($this->check_out->clone()->startOfDay()) + 1;
    }

    /**
     * Total harga transaksi (durasi × harga kamar).
     */
    public function getTotalPriceAttribute(): int
    {
        return $this->duration * $this->Room->price;
    }

    /**
     * Total pembayaran yang sudah tersimpan (status ≠ Pending).
     */
    public function getTotalPaymentAttribute(): int
    {
        return $this->Payments()
                    ->where('status', '!=', 'Pending')
                    ->sum('price');
    }

    /**
     * Minimal down‑payment (15 % dari total harga).
     * Silakan ubah persen sesuai kebutuhan.
     */
    public function getMinimumDownPaymentAttribute(): int
    {
        return (int) round($this->total_price * 0.15);
    }

    /**
     * Format “X Day / Days” (mis. "1 Day", "3 Days").
     */
    public function getDateDifferenceWithPlural(): string
    {
        return $this->duration . ' ' . Str::plural('Day', $this->duration);
    }

    

    /* ======================================
     | BACKWARD‑COMPAT: method lama tetap ada |
     ====================================== */

    // dipakai di Blade / controller lama
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function getTotalPayment()
    {
        return $this->total_payment;
    }

    public function getMinimumDownPayment()
    {
        return $this->minimum_down_payment;
    }
}
