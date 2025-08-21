<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">AULA KAMI</h2>
<div class="container">
    <div class="row">

        @foreach ($room as $r)
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    @if ($r->images->count() > 0)
                        <img src="{{ asset('storage/' . $r->images[0]->image) }}" class="img-fluid rounded"
                            style="height: 250px">
                    @else
                        <img src="/nyoba/images/rooms/1.jpg" class="img-fluid rounded">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $r->type->name }} #{{ $r->no }}</h5>
                        <h6 class="mb-3 text-success">IDR {{ number_format($r->price) }} </h6>
                        <div class="guests mb-2">
                            <h6 class="mb-1">Tamu</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                {{ $r->capacity }}
                            </span>
                        </div>
                        <div class="features mb-4">
                            <h6 class="mb-1"></h6>
                            @if ($r->capacity <= 5)
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    2 Rooms
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 Bathroom
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 Balcony
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    2 Sofa
                                </span>
                        </div>
                        <div class="Facilities mb-3">
                            <h6 class="mb-1">Facilities</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">Wifi</span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">Television</span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">AC</span>
                        @elseif ($r->capacity <= 10)
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                3 Rooms
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Bathroom
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Balcony
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                4 Sofa
                            </span>
                        </div>
                        <div class="Facilities mb-3">
                            <h6 class="mb-1">Fasilitas</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Wifi
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Television
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                AC
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Infokus
                            </span>
                        @else
                            {{-- <span class="badge rounded-pill bg-light text-dark text-wrap">
                                4 Rooms
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Bathroom
                            </span> --}}
                            {{-- <span class="badge rounded-pill bg-light text-dark text-wrap">
                                2 Balcony
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                6 Sofa
                            </span> --}}
                        </div>
                        <div class="Facilities mb-3">
                            {{-- <h6 class="mb-1">Facilities</h6>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Wifi
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Television
                            </span> --}}
                            {{-- <span class="badge rounded-pill bg-light text-dark text-wrap">
                                AC
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Room Heater
                            </span>
                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                Smooke Room
                            </span> --}}
        @endif
    </div>
    <div class="d-flex justify-content-evenly mb-2">
        <a href="/rooms/{{ $r->no }}" class="btn btn-sm border border-black btn- shadow-none">pesan sekarang</a>
        <a href="/rooms/{{ $r->no }}" class="btn btn-sm btn-dark shadow-none">Lebih detail</a>
    </div>

</div>
</div>
</div>
@endforeach
<div class="col-lg-12 text-center mt-5">
    <a href="/rooms" class="btn btn-sm btn-dark rounded-0 fw-bold shadow-none">Aula</a>
</div>
</div>
</div>
