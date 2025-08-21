@extends('frontend.inc.main')
@section('title')
    <title>AULA DINAS KOMINFO NTT | Cari Kamar</title>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    {{-- <style>
        /* tanggal dipesan (booked) */
        .fc-daygrid-day.booked-date {
            background: #ffecec !important;
            color: #d10000 !important;
            cursor: not-allowed;
        }
        .fc-daygrid-day.booked-date .fc-daygrid-day-frame {
            background: #ffecec;
        }
        /* rentang yang dipilih user */
        .fc-daygrid-day.selected-range {
            background: #e6f7ff !important;
        }
        /* header kalender */
        .fc-header-toolbar {
            padding: 10px;
            margin-bottom: 5px !important;
        }
        /* tombol kalender */
        .fc-button {
            padding: 5px 10px !important;
            font-size: 0.9rem !important;
        }
    </style> --}}
        <style>
        /* =====================
           CUSTOM FULLCALENDAR
        ======================*/
        /* tanggal dipesan (booked) */
        .fc-daygrid-day.booked-date {
            background:#ffecec !important;
            color:#d10000 !important;
            cursor:not-allowed;
        }
        .fc-daygrid-day.booked-date .fc-daygrid-day-frame{background:#ffecec}

        /* rentang dipilih user */
        .fc-daygrid-day.selected-range{background:#e6f7ff !important;}

        /* perbaikan header agar Sun/Mon dst tidak menumpuk */
        #calendar .fc-scrollgrid-sync-table{table-layout:fixed;}
        #calendar .fc-col-header-cell-cushion{
            display:inline-block;
            width:100%;
            text-align:center;
            white-space:nowrap;
            font-size:0.85rem;
            font-weight:600;
            padding:4px 0;
        }

        /* perbesar setiap sel kalender supaya angka tidak bertabrakan */
        .fc-daygrid-day{min-height:80px;}          /* atur tinggi sel */
        .fc-daygrid-day-frame{padding:6px;}        /* sedikit ruang dalam sel */
        .fc-daygrid-day-number{font-size:0.9rem;}  /* angka tanggal */

        /* toolbar & tombol */
        .fc-header-toolbar{padding:10px;margin-bottom:6px !important;}
        .fc-button{padding:5px 10px !important;font-size:0.9rem !important;}

        /* opsional: responsive fix */
        #calendar{max-width:100%;margin:0 auto;}
    </style>
@endsection

@section('content')
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">AULA KAMI</h2>
        <p class="h5 mt-3 text-center">{{ $roomsCount }} Aula Tersedia</p>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container">
        <div class="row">
            {{-- FILTER SIDEBAR --}}
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-0">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">FILTERS</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <form action="/rooms" method="GET">
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size:18px;">CEK KETERSEDIAAN</h5>
                                    <div id="calendar" style="width:100%;"></div>
                                    <input type="hidden" id="from" name="from" value="{{ request('from') }}">
                                    <input type="hidden" id="to" name="to" value="{{ request('to') }}">
                                </div>
                                <button class="btn border w-100" type="submit">CARI</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>

            {{-- LIST ROOMS --}}
            <div class="col-lg-9 col-md-12 px-4">
                @foreach ($rooms as $r)
                    <div class="card mb-4 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                @if ($r->images->count())
                                    <img src="{{ asset('storage/'.$r->images[0]->image) }}" class="img-fluid rounded" style="max-height:170px;object-fit:cover;width:100%;">
                                @else
                                    <img src="/img/kamar1.jpg" class="img-fluid rounded" style="max-height:170px;object-fit:cover;width:100%;">
                                @endif
                            </div>

                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                <h5 class="mb-3">{{ $r->type->name }} #{{ $r->no }}</h5>
                                <div class="guests mb-3">
                                    <h6 class="mb-1">Kapasitas</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">{{ $r->capacity }} Orang</span>
                                </div>
                                <div class="facilities mb-2">
                                    <h6 class="mb-1">Fasilitas:</h6>
                                    @foreach ($r->facilities ?? [] as $facility)
                                        <span class="badge rounded-pill bg-light text-dark text-wrap mb-1">{{ $facility->name }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                <h6 class="mb-4 text-success">IDR {{ number_format($r->price) }}</h6>
                                @if(request()->filled(['from','to']))
                                    <form action="/order" method="POST" class="mb-2">
                                        @csrf
                                        <input type="hidden" name="room" value="{{ $r->id }}">
                                        <input type="hidden" name="from" value="{{ request('from') }}">
                                        <input type="hidden" name="to" value="{{ request('to') }}">
                                        <button class="btn btn-sm w-100 btn-light border border-dark shadow-none">Pesan sekarang</button>
                                    </form>
                                @endif
                                <a href="/rooms/{{ $r->no }}" class="btn btn-sm w-100 btn-dark shadow-none">Lebih detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center">
                    {!! $rooms->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bookedDates = @json($bookedDates ?? []);
            const fromParam = "{{ request('from') }}";
            const toParam = "{{ request('to') }}";
            
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                selectable: true,
                selectOverlap: false,
                selectAllow: (selectInfo) => {
                    const start = selectInfo.start;
                    const end = new Date(selectInfo.end);
                    end.setDate(end.getDate() - 1); // end is exclusive
                    
                    let current = new Date(start);
                    while (current <= end) {
                        const dateStr = current.toISOString().split('T')[0];
                        if (bookedDates.includes(dateStr)) {
                            return false;
                        }
                        current.setDate(current.getDate() + 1);
                    }
                    return true;
                },
                dayCellClassNames: (arg) => {
                    const dateStr = arg.date.toISOString().split('T')[0];
                    return bookedDates.includes(dateStr) ? ['booked-date'] : [];
                },
                select: (selectInfo) => {
                    // Clear previous selection
                    document.querySelectorAll('.selected-range').forEach(el => {
                        el.classList.remove('selected-range');
                    });
                    
                    // Highlight new selection
                    let current = new Date(selectInfo.start);
                    const end = new Date(selectInfo.end);
                    end.setDate(end.getDate() - 1);
                    
                    while (current <= end) {
                        const dateStr = current.toISOString().split('T')[0];
                        const dayEl = document.querySelector(`[data-date="${dateStr}"]`);
                        if (dayEl) dayEl.classList.add('selected-range');
                        current.setDate(current.getDate() + 1);
                    }
                    
                    // Set form values
                    document.getElementById('from').value = selectInfo.startStr;
                    const adjustedEnd = new Date(selectInfo.end);
                    adjustedEnd.setDate(adjustedEnd.getDate() - 1);
                    document.getElementById('to').value = adjustedEnd.toISOString().split('T')[0];
                },
                datesSet: (dateInfo) => {
                    // Reapply selected range when month changes
                    if (fromParam && toParam) {
                        const start = new Date(fromParam);
                        const end = new Date(toParam);
                        
                        let current = new Date(start);
                        while (current <= end) {
                            const dateStr = current.toISOString().split('T')[0];
                            const dayEl = document.querySelector(`[data-date="${dateStr}"]`);
                            if (dayEl) dayEl.classList.add('selected-range');
                            current.setDate(current.getDate() + 1);
                        }
                    }
                }
            });
            
            calendar.render();
            
            // Apply initial selection if params exist
            if (fromParam && toParam) {
                const start = new Date(fromParam);
                const end = new Date(toParam);
                
                let current = new Date(start);
                while (current <= end) {
                    const dateStr = current.toISOString().split('T')[0];
                    const dayEl = document.querySelector(`[data-date="${dateStr}"]`);
                    if (dayEl) dayEl.classList.add('selected-range');
                    current.setDate(current.getDate() + 1);
                }
            }
        });
    </script>
@endsection