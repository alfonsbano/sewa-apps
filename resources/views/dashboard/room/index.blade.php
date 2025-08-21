@extends('dashboard.layout.main')
@section('title')
    <title>Dashboard | Aula</title>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="container">
        <div class="col-md-6">
            <div class="d-flex align-items-center mb-4">
                <h1 class="h2 mb-0 text-dark-1000">Room</h1>
                <a href="room/create" class="btn btn-sm shadow border ms-2 mt-1 p-2"><i class="fas fa-plus"></i></a>
            </div>
        </div>

        <div class="col-md-6">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert"> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Content Row -->
    <div class="container">
        <div class="card border-0 shadow">
            <div class="card-header">
                <h5>Total data {{ $p }}</h5>
            </div>
            <div class="card-body">
                <div class="col-md-auto">
                    <table class="table table-responsive table-sm table-bordered" id="myTable">
                        <thead class="table-secondary">
                            <tr>
                                <th width="5%">#</th>
                                <th width="5%">Id</th>
                                <th>No</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>kapasitas</th>
                                <th>Harga/Hari</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($room as $r)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->no }}</td>
                                    <td>{{ $r->type->name }}</td>
                                    <td>{{ $r->status->name }}</td>
                                    <td>{{ $r->capacity }}</td>
                                    <td>Rp.{{ number_format($r->price) }}</td>
                                    <td class="d-flex">
                                        <a href="room/{{ $r->id }}/edit" class="btn btn-success me-1"><i
                                                class="fas fa-pen"></i></a>
                                        <a class="btn btn-danger me-1" href="#" data-toggle="modal"
                                            data-target="#deletemodal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="/dashboard/data/room/{{ $r->no }}"
                                            class="btn btn-warning text-light me-1"><i class="fas fa-eye"></i></i></i> </a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this
                                                    data?</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Select "Delete" below if you are ready to delete.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Cancel</button>
                                                <form action="/dashboard/data/room/{{ $r->id }}/delete"
                                                    method="post">
                                                    @csrf
                                                    <button class="btn btn-danger me-1" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>No</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Kapasitas</th>
                                <th>Harga/Hari</th>
                                <th width="14%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- End of Main Content -->
