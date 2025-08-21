@extends('frontend.inc.main')
@section('title')
    <title>AULA KOMINFO | KONTAK KAMI</title>
@endsection

@section('content')
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">KONTAK KAMI</h2>
    </div>

    <div class="container mb-5">
        <div style="margin-bottom:140px" class="bg-white rounded shadow p-4">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8 col-md-6 mb-5 px-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3927.133539331994!2d123.59652327362822!3d-10.169799209796038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569ca3bd22c2f3%3A0x2d6d15b21bf70a5e!2sDinas%20Komunikasi%20dan%20Informatika%20(Diskominfo)%20Provinsi%20NTT!5e0!3m2!1sid!2sid!4v1741144298077!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        {{-- <iframe class="w-100 rounded" height="320px"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.226155440485!2d123.593195274293!3d-10.177918989978814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e36b0236d5d3d4b%3A0xf3f2d1b5b24a64c7!2sDinas%20Komunikasi%20dan%20Informatika%20Provinsi%20NTT!5e0!3m2!1sid!2sid!4v1709664328437"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                    </div>
                    <div class="col-lg-4">
                        <h5>Alamat</h5>
                        <a href="https://goo.gl/maps/PQByjKcU5Ft3mAxg9" target="_blank"
                            class="d-inline-block text-decoration-none text-dark mb-2">
                            <i class="bi bi-geo-alt-fill"></i> Dinas Komunikasi dan Informatika Provinsi NTT, 
                            Jl. Palapa No.11, Oebobo, Kupang, Nusa Tenggara Timur
                        </a>
                        <h5 class="mt-4">Hubungi Kami</h5>
                        <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +62 380 820266
                        </a>
                        <br>
                        <a href="#" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +62 380 820267
                        </a>
                        <h5 class="mt-4">Email</h5>
                        <a href="mailto:diskominfo@nttprov.go.id" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <i class="bi bi-envelope-fill"></i> diskominfo@nttprov.go.id
                        </a>

                        <h5 class="mt-4">Ikuti Kami</h5>
                        <a href="#" class="d-inline-block text-dark fs-5 me-2">
                            <i class="bi bi-twitter me-1"></i>
                        </a>

                        <a href="#" class="d-inline-block text-dark fs-5 me-2">
                            <i class="bi bi-facebook me-1"></i>
                        </a>

                        <a href="#" class="d-inline-block text-dark fs-5">
                            <i class="bi bi-instagram me-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
