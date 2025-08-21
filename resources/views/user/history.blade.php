@extends('frontend.inc.main')

@section('title')
    <title>SEWA AULA PALAPA | HISTORY PEMESANAN</title>
@endsection

@section('content')
<div class="container" style="margin-top:30px;margin-bottom:310px">
    <div class="row">
        {{-- Kartu profil kiri --}}
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if ($user->image)
                        <img src="{{ asset('storage/'.$user->image) }}" class="rounded-circle img-fluid" style="width:150px" alt="avatar">
                    @else
                        <img src="/img/default-user.jpg" class="rounded-circle img-fluid" style="width:150px" alt="avatar">
                    @endif
                    <div class="d-flex justify-content-center mt-3">
                        <div>
                            <h5 class="mb-1">History Pemesanan</h5>
                            <h3>{{ $user->Customer->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar transaksi --}}
        <div class="col-lg-7 col-md-12 px-4">
            @foreach ($his as $h)
                <div class="card mb-4 border-0 shadow">
                    <div class="d-flex p-3 justify-content-between">

                        {{-- Info dasar --}}
                        <div class="pe-2">
                            <h5 class="mb-1">#{{ $loop->iteration }} {{ $h->invoice }}</h5>
                            <h6 class="mb-1">
                                Status:
                                @if ($h->status == 'Pending' && $h->image)
                                    <span class="text-danger">{{ $h->status }}</span> | Sudah Bayar
                                @elseif ($h->status == 'Pending')
                                    <span class="text-danger">{{ $h->status }}</span>
                                @else
                                    <span class="text-success">{{ $h->status }}</span>
                                @endif
                            </h6>
                            <h6 class="mb-1">Total IDR {{ number_format($h->price) }}</h6>
                        </div>

                        {{-- Aksi --}}
                        <div class="text-end">
                            <h6 class="text-dark">{{ $h->created_at }}</h6>

                            {{-- CASE: Pending + belum upload bukti bayar --}}
                            @if ($h->status == 'Pending' && $h->image == null)
                                {{-- Bayar --}}
                                <a href="/bayar/{{ $h->id }}" class="btn btn-danger btn-sm w-100 mb-2">Bayar Sekarang</a>

                                {{-- Batalkan --}}
                                <form action="{{ route('order.cancel', $h->id) }}" method="POST"
                                      class="d-inline w-100 mb-2"
                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                                        Batalkan Pesanan
                                    </button>
                                </form>

                                {{-- Invoice (disabled) --}}
                                <a class="btn btn-secondary btn-sm w-100" style="pointer-events:none;">Lihat Invoice</a>

                            {{-- CASE: Pending + sudah upload bukti (menunggu verifikasi) --}}
                            @elseif ($h->status == 'Pending' && $h->image)
                                <a class="btn btn-danger btn-sm w-100 mb-2" style="pointer-events:none;">Tunggu Konfirmasi</a>
                                <a class="btn btn-secondary btn-sm w-100" style="pointer-events:none;">Lihat Invoice</a>

                            {{-- CASE: Lunas / selesai --}}
                            @else
                                <a href="/invoice/{{ $h->id }}" class="btn btn-dark btn-sm w-100">Lihat Invoice</a>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- pagination --}}
            {!! $his->links() !!}
        </div>
    </div>
</div>
@endsection
