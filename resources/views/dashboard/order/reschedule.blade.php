@extends('dashboard.layout.main')

@section('title')
    <title>Reschedule Order</title>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>Reschedule Transaksi - {{ $transaction->Customer->name ?? 'Tanpa Nama' }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.reschedule.update', $transaction->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="check_in">Check In</label>
                    <input type="date" name="check_in" class="form-control" value="{{ $transaction->check_in->format('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label for="check_out">Check Out</label>
                    <input type="date" name="check_out" class="form-control" value="{{ $transaction->check_out->format('Y-m-d') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a> --}}
                <a href="{{ url('/dashboard/order') }}" class="btn btn-secondary">Kembali ke Order</a>

            </form>
            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Action</th> <!-- Tambahan -->
        </tr>
    </thead>
    <tbody>
        @foreach($otherTransactions as $other)
            <tr>
                <td>{{ $other->Customer->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($other->check_in)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($other->check_out)->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.reschedule.form', $other->id) }}" class="btn btn-sm btn-warning">
                        Reschedule
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

            {{-- @if ($otherTransactions->count())
    <div class="mt-5">
        <h5>Jadwal Lain di Ruangan Ini</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($otherTransactions as $other)
                    <tr>
                        <td>{{ $other->Customer->name ?? '-' }}</td>
                        <td>{{ $other->check_in->format('d M Y') }}</td>
                        <td>{{ $other->check_out->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif --}}

        </div>
    </div>
</div>
@endsection
