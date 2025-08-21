<?php

namespace App\Http\Controllers;

use App\Events\NewReservationEvent;
use App\Events\RefreshDashboardEvent;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NewRoomReservationDownPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /* =============================================================
       FORMULIR PEMESANAN
    ============================================================= */
    public function index(Request $request)
    {
        if (auth()->guest()) {
            Alert::error('Please Login First!');
            return redirect('/login');
        }

        $stayfrom  = Carbon::parse($request->from);
        $stayuntil = Carbon::parse($request->to);
        $room      = Room::findOrFail($request->room);

        /* ===== cek overlap hanya untuk Reservation & Paid ===== */
        $overlap = Transaction::where('room_id', $room->id)
            ->whereIn('status', ['Reservation', 'Paid'])
            ->where(function ($q) use ($stayfrom, $stayuntil) {
                $q->whereBetween('check_in',  [$stayfrom, $stayuntil])
                  ->orWhereBetween('check_out', [$stayfrom, $stayuntil])
                  ->orWhere(function ($qq) use ($stayfrom, $stayuntil) {
                      $qq->where('check_in', '<=', $stayfrom)
                         ->where('check_out', '>=', $stayuntil);
                  });
            })->exists();
        if ($overlap) {
            Alert::error('Kamar Tidak Tersedia');
            return back();
        }

        $customerId = $request->customer ?? auth()->user()->Customer->id;
        $customer   = Customer::findOrFail($customerId);

        /* ========== PERHITUNGAN DURASI & TOTAL ========== */
        // diffInDays() mengembalikan 0 jika tanggal sama, jadi tambah +1
        // $dayDifference = max(1, $stayfrom->diffInDays($stayuntil));
        $dayDifference = $stayfrom->diffInDays($stayuntil) + 1;
        $total         = $room->price * $dayDifference;

        $paymentmet = PaymentMethod::where('id', '>', 1)->get();

        return view('frontend.order', compact(
            'customer',
            'room',
            'stayfrom',
            'stayuntil',
            'dayDifference',
            'total',
            'paymentmet'
        ));
    }

    /* =============================================================
       KONFIRMASI & SIMPAN TRANSAKSI
    ============================================================= */
    public function order(Request $request)
    {
        $rooms     = Room::findOrFail($request->room);
        $customers = Customer::findOrFail($request->customer);

        $from = Carbon::parse($request->check_in);
        $to   = Carbon::parse($request->check_out);

        $overlap = Transaction::where('room_id', $rooms->id)
            ->whereIn('status', ['Reservation', 'Paid'])
            ->where(function ($q) use ($from, $to) {
                $q->whereBetween('check_in',  [$from, $to])
                  ->orWhereBetween('check_out', [$from, $to])
                  ->orWhere(function ($qq) use ($from, $to) {
                      $qq->where('check_in', '<=', $from)
                         ->where('check_out', '>=', $to);
                  });
            })->exists();
        if ($overlap) {
            Alert::error('Kamar Tidak Tersedia');
            return back();
        }

        if (is_null($customers->nik)) {
            Alert::error('Kesalahan Data', 'Mohon Isi Data NIK');
            return redirect('myaccount');
        }

        $trx  = $this->storeTransaction($request, $rooms);
        $pay  = $this->storePayment($request, $trx, 'Pending');

        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $adm) {
            event(new NewReservationEvent('Reservation added by '.$customers->name, $adm));
            $adm->notify(new NewRoomReservationDownPayment($trx, $pay));
        }
        event(new RefreshDashboardEvent('Seseorang memesan kamar'));

        Alert::success('Thanks!', 'Aula '.$rooms->no.' telah dipesan. Silakan bayar sekarang!');
        return redirect('/bayar/'.$trx->id);
    }

    /* =============================================================
       PEMBAYARAN & INVOICE
    ============================================================= */
    public function invoice($id)
    {
        $p = Payment::with('Customer','Transaction','Methode')->findOrFail($id);
        if ($p->status === 'Pending') abort(404);
        return view('frontend.invoice', compact('p'));
    }

    // public function pembayaran($id)
    // {
    //     $t   = Transaction::with('Room','Payments')->findOrFail($id);
    //     $pay = $t->Payments->where('status','Pending')
    //                        ->where('payment_method_id','>',1)
    //                        ->first();
    //     if (!$pay || ($pay->image && $pay->status==='Pending')) return back();
    //     $price = $t->Room->price;
        
    //     return view('frontend.bayar', compact('t','price','pay'));
    // }
    public function pembayaran($id)
{
    $t   = Transaction::with('Room','Payments')->findOrFail($id);
    $pay = $t->Payments->where('status','Pending')
                       ->where('payment_method_id','>',1)
                       ->first();

    if (!$pay || ($pay->image && $pay->status==='Pending')) return back();

    // ✅ Hitung jumlah hari dan total harga
    $check_in = Carbon::parse($t->check_in);
    $check_out = Carbon::parse($t->check_out);
    $total_days = $check_in->diffInDays($check_out) + 1;

    $price = $t->Room->price * $total_days;

    return view('frontend.bayar', compact('t','price','pay'));
}


    public function bayar(Request $request)
    {
        $request->validate(['image'=>'required|image|file']);
        $imgPath = $request->file('image')->store('bukti-images','public');
        Payment::findOrFail($request->id)->update(['image'=>$imgPath]);
        Alert::success('Pembayaran Berhasil','Tunggu Konfirmasi!');
        return redirect('/history');
    }

    /* =============================================================
       BATALKAN RESERVASI
    ============================================================= */
    public function cancel($id)
    {
        $trx = Transaction::where('id',$id)
                ->where('c_id',auth()->user()->Customer->id)
                ->where('status','Reservation')
                ->firstOrFail();

        $trx->status = 'Cancelled';
        $trx->save();

        foreach ($trx->Payments as $p) {
            if ($p->status==='Pending') {
                $p->status='Cancelled';
                $p->save();
            }
        }
        Alert::success('Pesanan berhasil dibatalkan');
        return back();
    }

    /* =============================================================
       HELPER PRIVATE
    ============================================================= */
    private function storeTransaction($req, $room)
    {
        return Transaction::create([
            'room_id'   => $room->id,
            'c_id'      => $req->customer,
            'check_in'  => $req->check_in,
            'check_out' => $req->check_out,
            'status'    => 'Reservation'
        ]);
    }


// public function showRescheduleForm($id)
// {
//     $transaction = \App\Models\Transaction::findOrFail($id);
//     return view('dashboard.order.reschedule', compact('transaction'));
// }
// public function showRescheduleForm($id)
// {
//     $transaction = \App\Models\Transaction::findOrFail($id);

//     // Ambil semua transaksi lain untuk referensi jadwal
//     $otherTransactions = \App\Models\Transaction::where('id', '!=', $id)
//         ->where('room_id', $transaction->room_id)
//         ->orderBy('check_in')
//         ->get();

//     return view('dashboard.order.reschedule', compact('transaction', 'otherTransactions'));
// }
public function showRescheduleForm($id)
{
    $transaction = Transaction::findOrFail($id);

    // Ambil semua transaksi lain yang memakai ruangan yang sama, kecuali yang sedang diedit
    $otherTransactions = Transaction::where('room_id', $transaction->room_id)
        ->where('id', '!=', $transaction->id)
        ->orderBy('check_in')
        ->get();

    return view('dashboard.order.reschedule', [
        'transaction' => $transaction,
        'otherTransactions' => $otherTransactions
    ]);
}


public function updateReschedule(Request $request, $id)
{
    $request->validate([
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
    ]);

    $transaction = Transaction::findOrFail($id);
    $transaction->check_in = $request->check_in;
    $transaction->check_out = $request->check_out;
    // $transaction->duration = \Carbon\Carbon::parse($request->check_in)->diffInDays($request->check_out);
    $transaction->save();

   
    return redirect()->route('transaction.index')->with('success', '...');

}






    private function storePayment($req, $trx, $status)
    {
        $inv = '0'.$req->customer.'INV'.(Payment::count()+1).Str::random(4);
        return Payment::create([
            'c_id'             => $req->customer,
            'transaction_id'   => $trx->id,
            'price'            => $req->price,
            'status'           => $status,
            'payment_method_id'=> $req->payment_method_id,
            'invoice'          => $inv
        ]);
    }
}
