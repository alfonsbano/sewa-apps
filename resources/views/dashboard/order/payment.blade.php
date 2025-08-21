@extends('dashboard.layout.main')

@section('title')
    <title>Dashboard | Payment</title>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="container mt-3">
        <div class="row justify-content-md-center">
            {{-- =========================== FORM PEMBAYARAN =========================== --}}
            <div class="col-md-8 mt-2">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-sm-12">
                                {{-- Room --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Room</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" value="{{ $transaction->Room->no }}" readonly>
                                    </div>
                                </div>

                                {{-- Check‑in --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Check In</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="{{ $transaction->check_in->isoFormat('D MMMM Y') }}" readonly>
                                    </div>
                                </div>

                                {{-- Check‑out --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Check Out</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="{{ $transaction->check_out->isoFormat('D MMMM Y') }}" readonly>
                                    </div>
                                </div>

                                {{-- Harga kamar --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Room Price</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="IDR {{ number_format($transaction->Room->price) }}" readonly>
                                    </div>
                                </div>

                                {{-- Durasi hari --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Days Count</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="{{ $transaction->getDateDifferenceWithPlural() }}" readonly>
                                    </div>
                                </div>

                                {{-- Total harga --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Total Price</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="IDR {{ number_format($transaction->getTotalPrice()) }}" readonly>
                                    </div>
                                </div>

                                {{-- Sudah dibayar --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Paid Off</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="IDR {{ number_format($transaction->getTotalPayment()) }}" readonly>
                                    </div>
                                </div>

                                {{-- Kekurangan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Insufficient</label>
                                    <div class="col-sm-10">
                                        <input class="form-control"
                                               value="IDR {{ number_format($transaction->getTotalPrice() - $transaction->getTotalPayment()) }}"
                                               readonly>
                                    </div>
                                </div>

                                <hr>

                                {{-- Form input pembayaran --}}
                                <div class="col-sm-12 mt-2">
                                    <form method="POST" action="{{ route('paydebt') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $transaction->id }}">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Payment</label>
                                            <div class="col-sm-10">
                                                <input id="payment" name="payment" type="text"
                                                       class="form-control @error('payment') is-invalid @enderror"
                                                       placeholder="Input payment here"
                                                       value="{{ old('payment') }}">
                                                @error('payment')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10" id="showPaymentType"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-end">Pay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =========================== PROFIL CUSTOMER =========================== --}}
            <div class="col-md-4 mt-2">
                <div class="card shadow border-0">
                    @if ($transaction->User->image)
                        <img src="{{ asset('storage/' . $transaction->User->image) }}"
                             style="border-top-right-radius:.5rem;border-top-left-radius:.5rem">
                    @else
                        <img src="/img/default-user.jpg"
                             style="border-top-right-radius:.5rem;border-top-left-radius:.5rem">
                    @endif
                    <div class="card-body">
                        <table>
                            <tr>
                                <td style="width:50px;text-align:center">
                                    <i class="fas {{ $transaction->Customer->gender == 'Male' ? 'fa-male' : 'fa-female' }}"></i>
                                </td>
                                <td>{{ $transaction->Customer->name }}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><i class="fas fa-user-md"></i></td>
                                <td>{{ $transaction->Customer->job }}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><i class="fas fa-birthday-cake"></i></td>
                                <td>{{ $transaction->Customer->birthdate }}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><i class="fas fa-map-marker-alt"></i></td>
                                <td>{{ $transaction->Customer->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Format mata uang realtime saat ketik --}}
        <script src="/style/js/jquery.js"></script>
        <script>
            $('#payment').keyup(function () {
                const val = parseFloat($(this).val() || 0);
                $('#showPaymentType').text('Rp. ' + val.toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            });
        </script>
    </div>
@endsection
<!-- End of Main Content -->
