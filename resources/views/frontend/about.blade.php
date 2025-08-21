@extends('frontend.inc.main')
@section('title') <title>AULA KOMINFO | TENTANG KAMI</title> @endsection

@section('content')

<div class="container mt-5 mb-5" style="margin-bottom:100px">
    <div class="row d-flex justify-content-center">
    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="/nyoba/images/about/hotel.svg" width="70px">
        <h4 class="mt-3">Aula</h4>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="/nyoba/images/about/customers.svg" width="70px">
        <h4 class="mt-3">Pelanggangan</h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
            <img src="/nyoba/images/about/t.png" width="70px">
            <h4 class="mt-3">Bayar</h4>
        </div>
    </div>

</div>
</div>


<div class="container mt-5 mb-5" style="margin-bottom:100px">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-6 col-md-5 mb-4 justify order-lg-1 order-md-1 order-2 text-center mt-4 mt-lg-0 mt-md-0">
        <h3 class="mb-3 ">Tentang Kami</h3>
        <p>
          Sewa Aula Dinas kominfo bisa digunakan untuk Rapat dan Acara penting lainnya disediakan juga dengan fasilitas untuk rapat dan acara lainnya
        </p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
        <img src="/img/kamar/aula321.jpeg" class="w-100 d-block">
        {{-- <img src="/nyoba/images/carousel/2.png" class="w-100 d-block">
        <img src="/nyoba/images/carousel/3.png" class="w-100 d-block"> --}}
      </div>
    </div>
  </div>


@endsection
