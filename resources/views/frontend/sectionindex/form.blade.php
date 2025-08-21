<div class="container availability-form">
    <div class="row">
<div class="col-lg-12 bg-white shadow p-4 rounded" style="overflow:hidden">
            <h1 class="marquee-text">SEWA AULA PALAPA DINAS KOMINFO PROVINSI NTT</h1>
            <style>
                .marquee-text {
                    display: inline-block;
                    animation: marquee 15s linear infinite;
                    white-space: nowrap;
                    position: relative;
                    left: 100%;
                }
                @keyframes marquee {
                    0% { left: 100%; }
                    100% { left: -100%; }
                }
            </style>

            <h5 class="text-center"></h5>


            <form method="get" action="/rooms">
                @csrf
                <div class="row align-items-end">
                    <!-- Check-in -->
                    {{-- <div class="col-lg-6 mb-3">
                        <label class="form-label" style="font-weight: 500;">Check-in</label>
                        <input type="date" name="check_in_date" id="check_in_date" class="form-control shadow-none">
                        <select name="check_in_hour" id="check_in_hour" class="form-control shadow-none mt-2">
                            @for ($i = 0; $i < 24; $i++)
                                <option value="{{ $i }}">{{ $i }}:00</option>
                            @endfor
                        </select>
                    </div> --}}

                    <!-- Check-out -->
                    {{-- <div class="col-lg-6 mb-3">
                        <label class="form-label" style="font-weight: 500;">Check-out</label>
                        <input type="date" name="check_out_date" id="check_out_date" class="form-control shadow-none">
                        <select name="check_out_hour" id="check_out_hour" class="form-control shadow-none mt-2">
                            @for ($i = 0; $i < 24; $i++)
                                <option value="{{ $i }}">{{ $i }}:00</option>
                            @endfor
                        </select>
                    </div> --}}

                    {{-- <div class="col-lg-3 mb-3">
                        <label class="form-label" style="font-weight: 500;">Orang</label>
                        <input type="number" name="count" class="form-control shadow-none" id="count" value="1">
                    </div>
                    <div class="col-lg-1 mb-lg-3 mt-2">
                        <button type="submit" class="btn shadow-none border">Submit</button>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
</div>



{{-- <div class="container availability-form">
    <div class="row">
        <div class="col-lg-12 bg-white shadow p-4 rounded">
            <h5 class="col-lg-3">Check Booking Availability</h5>
            <form method="get" action="/rooms">
               @csrf
                <div class="row align-items-end">
                    <div class="col-lg-4 mb-3">
                        <label class="form-label" style="font-weight: 500;">Check-in</label>
                        <input type="date" name="from" id="from" class="form-control shadow-none">
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class="form-label" style="font-weight: 500;">Check-in</label>
                        <input type="date" name="to" id="to" class="form-control shadow-none">
                    </div>
                    <div class="col-lg-3 mb-3">
                    <label class="form-label" style="font-weight: 500;">Person</label>
                    <input type="number" name="count" class="form-control shadow-none" id="count" value="1">
                    </div>
                    <div class="col-lg-1 mb-lg-3 mt-2">
                        <button type="submit" class="btn shadow-none border">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div> --}}
