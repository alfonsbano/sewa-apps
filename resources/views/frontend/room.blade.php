@extends('frontend.inc.main')
@section('title')
    <title>SEWA AULA PALAPA | AULA #{{ $room->no }}</title>
@endsection

@section('css')
    <style>
        @media (max-width: 576px) {
            .room-title {
                font-size: 18px;
            }

            .room-price {
                font-size: 12px;
            }

            .desc-title {
                font-size: 16px;
            }

            .desc-subtitle {
                font-size: 12px;
            }

            .desc-content {
                font-size: 10px;
            }
        }

        @media (min-width: 577px) and (max-width: 992px) {
            .room-title {
                font-size: 22px;
            }

            .room-price {
                font-size: 14px;
            }

            .desc-title {
                font-size: 18px;
            }

            .desc-subtitle {
                font-size: 16px;
            }

            .desc-content {
                font-size: 14px;
            }
        }

        @media (min-width: 993px) {
            .room-title {
                font-size: 26px;
            }

            .room-price {
                font-size: 16px;
            }

            .desc-title {
                font-size: 22px;
            }

            .desc-subtitle {
                font-size: 20px;
            }

            .desc-content {
                font-size: 18px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="modal fade" id="checkin" tabindex="-1" aria-labelledby="checkinLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="checkinLabel">Kapan?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/order">
                        @csrf
                        <input type="hidden" name="customer" value="{{ $customer }}">
                        <input type="hidden" name="room" value="{{ $room->id }}">
                        <div class="mb-3">
                            <label for="check_in" class="col-form-label">Check in</label>
                            <input type="date" class="form-control" required id="check_in" name="from">
                        </div>
                        <div class="mb-3">
                            <label for="check_out" class="col-form-label">Check out</label>
                            <input type="date" class="form-control" required id="check_out" name="to">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> Cek Tanggal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="my-5 px-4">
        {{-- <div class="h-line bg-dark"></div> --}}
    </div>

    <div class="container-fluid">

        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                @if ($room->images->count() > 0)
                    @foreach ($room->images as $room_images)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $room_images->image) }}" class="image-swipper d-block"
                                alt="{{ $room_images->image }}">
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <img src="/nyoba/images/carousel/1.png" class="image-swipper d-block" alt="1.png">
                    </div>
                @endif
            </div>

            <div class="swiper-pagination"></div>

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>
        </div>
    </div>

    <div class="container py-5">
        <div class="d-flex justify-content-between">
            <div class="col-md-6 col-lg-8 col-8">
                <h2 class="fw-bold h-font room-title">{{ $room->type->name }} {{ $room->no }}</h2>
            </div>
            <div class="col-md-6 col-lg-4 col-4 text-end">
                <h4 class="h-font room-price"><span class="text-success fw-bold"> IDR
                        {{ number_format($room->price) }}</span><span class="text-muted">/hari
                    </span></h4>
                <h6 style="font-size:10px"; class="text-muted">(max. {{ $room->capacity }} Orang) </h6>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-2">
            @if ($request->from)
                <form action="/order" method="POST">
                    @csrf
                    <input type="hidden" name="customer" value="{{ $customer }}">
                    <input type="hidden" name="room" value="{{ $room->id }}">
                    <input type="hidden" name="from" value="{{ $request->from }}">
                    <input type="hidden" name="to" value="{{ $request->to }}">
                    <button type="submit" class="btn btn-custom"> Pesan Sekarang </button>
                </form>
            @else
                <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#checkin"> Pesan
                    Sekarang </button>
            @endif
            </form>
        </div>

        <div class="col-md-12">
            <hr class="border border-secondary opacity-25 w-100">
        </div>

        <div class="col-md-12">
            <h4 class="mt-4 mb-4 desc-title"> Kebijakan Akomodasi</h4>
            <div class="d-flex">
                <div class="col-md-4 col-4 col-lg-4">
                    <h5 class="desc-subtitle">Prosedur Check-in</h5>
                </div>
                <div class="col-md-8 desc-content">
                    <p>Check in Jam 08:00</p>
                    <p>Check out Jam 16:00</p>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-4 col-4 col-lg-4 mt-4">
                    <h5 class="desc-subtitle">Kebijakan Lainnya</h5>
                </div>
                <div class="col-md-8 desc-content">
                    <h6 class="mt-4 desc-content">Merokok</h6>
                    <p>Dilarang Merokok di dalam aula, Namun dapat Merokok  diluar aula untuk perokok
                        aktif.</p>
                    <h6 class="mt-4 desc-content">Denda</h6>
                    <p>Checkout tidak boleh melebihi Jam yang telah di tentukan, Jika Pelanggan Checkout melewati Jam
                        yang di tentukan akan dikenakan Charge sebanyak Rp 100.000/Jam</p>
                </div>
            </div>

            <div class="d-flex">
                <div class="col-md-4 col-4 col-lg-4 mt-4">
                    <h5 class="desc-subtitle">Fasilitas</h5>
                </div>
                <div class="col-md-8 desc-content">

                    <h6 class="mt-4 desc-content">Free Wifi</h6>
                    <p>Fasilitas  yang ada pada Aula kami, Kami menyediakan Fasilitas free wifi dengan kecepatan
                        yang tinggi.</p>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <hr class="border border-secondary opacity-25 w-100">
        </div>

        <div class="col-md-12 mb-5">
            <div class="d-flex justify-content-between mt-4 mb-3">
                <h4> Lokasi </h4>
                <a href=""> Lihat MAPS</a>
            </div>
            <div class="d-flex justify-content-center w-100">
                <div class="col-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3927.133539331994!2d123.59652327362822!3d-10.169799209796038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569ca3bd22c2f3%3A0x2d6d15b21bf70a5e!2sDinas%20Komunikasi%20dan%20Informatika%20(Diskominfo)%20Provinsi%20NTT!5e0!3m2!1sid!2sid!4v1741144298077!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>s
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
