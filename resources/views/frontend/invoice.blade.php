<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>INVOICE |  {{$p->invoice}}</title>
    <link rel="stylesheet" href="/bs/css/bootstrap.min.css">
    <link rel="stylesheet" href="/invoice/style.css" media="all" />
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <style>
          @media print {
  body * {
    visibility: hidden;
  }
  #print * {
    visibility: visible;
    zoom: 110%;
  }
  #print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-md-center">

            <div class="col-md-4 mt-2">
                <div class="card shadow">
                    <div class="card-body">
                        <h2>INVOICE
                            @if ($p->status == 'Pending')
                            <span class="h5 text-danger">{{ $p->status }}</span>
                            @else
                            <span class="h5 text-success">{{ $p->status }}</span>
                            @endif
                        </h2>
                        <div class="d-flex">
                            <h5> #{{$p->invoice}}
                                @if ($p->status == 'Pending')
                                <a href="" style=" pointer-events: none;
                                cursor: default;" onclick="window.print()"><i class="fas fa-print" style="margin-top: 5px"></i></a> </h5> &nbsp;
                                @else
                                <a href="" onclick="window.print()"><i class="fas fa-print" style="margin-top: 5px"></i></a> </h5> &nbsp;
                                @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-2" >
                <div class="prints">
                <div class="card shadow" id="print">
                    <div class="card-body" style="margin-bottom: 100px">

                        <div class="col-md-12">
                            <header class="clearfix">
                        <h1 class="mb-5" style="text-align: center">INVOICE <span class="h4">#{{ $p->invoice }}</span></h1>
                        <div id="company" class="clearfix">
                            <div>Aula Palapa</div>
                            <div>Dinas Komunikasi dan Informatika Provinsi NTT<br /> , Jl.Palapa</div>
                            <div>+62 81352510913</div>
                            <div><a>dinaskominfontt.prov1@gmail.com</a></div>
                        </div>
                        <div id="project">
                            <div><span>Booking</span> Aula  {{$p->transaction->room->no}}  </div>
                            <div><span>CLIENT</span> {{$p->transaction->customer->name}}</div>
                            <div><span>Alamat</span> {{$p->transaction->customer->address}}
                            </div>
                            <div><span>EMAIL</span> <a> {{$p->transaction->customer->user->email }}</a></div>
                            <div><span>DATE</span> {{Carbon\Carbon::parse($p->transaction->check_in)->isoformat('D MMM YYYY')}}</div>
                            <div><span>DUE DATE</span>{{ Carbon\Carbon::parse($p->transaction->check_out)->isoformat('D MMM YYYY')}}</div>
                          </div>
                            </header>

                            <main class="overflow-auto">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th width="15%">ROOM</th>
                                      <th>CHECK IN</th>
                                      <th>CHECK OUT</th>
                                      <th>DAY</th>
                                      <th>PRICE</th>
                                      <th>TOTAL</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td class="text-center">{{$p->transaction->room->type->name}} # {{$p->transaction->room->no }}</td>
                                      <td class="text-center">{{Carbon\Carbon::parse($p->transaction->check_in)->isoformat('D MMM YYYY')}}</td>
                                      <td class="text-center">{{Carbon\Carbon::parse($p->transaction->check_out)->isoformat('D MMM YYYY')}}</td>
                                      <td class="unit text-center">{{ $p->transaction->check_in->diffindays($p->transaction->check_out) }} Days</td>
                                      <td class="qty text-center">{{number_format($p->transaction->room->price)}}</td>
                                      <td class="total text-center">{{ number_format($p->price) }}</td>
                                    </tr>

                                    <tr>
                                      <td colspan="4"></td>
                                      <td class="text-center">SUBTOTAL</td>
                                      <td class="total text-center">Rp.{{number_format($p->transaction->room->price)}}</td>
                                    </tr>
                                    <tr>
                                      <td colspan="4"></td>
                                      <td class="grand total text-center">GRAND TOTAL</td>
                                      <td class="grand total text-center">Rp. {{number_format($p->price) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                                {{-- <div id="notices">
                                  <div>NOTICE:</div>
                                  <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                                </div> --}}
                            </main>
                        </div>

                    </div>
                </div>
           </div>
        </div>

        </div>
    </div>
  </body>
@include('vendor.sweetalert.alert')

</html>
