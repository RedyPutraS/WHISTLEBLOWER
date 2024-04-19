@extends('dashboard.master.base')

@section('content')
    <div class="content__header content__boxed overlapping mb-4">
        <div class="content__wrap text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <i class="ri-home-4-line"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Dashboard
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Rekapitulasi Pengaduan
            </h1>
            <p class="lead">
                Cetak laporan rekapitulasi pengaduan
            </p>
            <div class="d-flex flex-wrap gap-2 justify-content-center mt-3 mb-4">
                <button type="button" onclick="window.print();" class="btn btn-secondary fw-bold">
                    <i class="ri-printer-line align-middle me-1"></i>
                    Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    <div class="content__boxed justify-content-center">
        <div class="content__wrap">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9 pt-2">
                            <h3 class="card-title text-center fw-bold mb-2">
                                Pengaduan Masuk dan Selesai per Bulan
                            </h3>
                            <div class="d-flex justify-content-center align-items-center my-3">
                                <button type="button" id="previous-year" class="_dm-iconButton btn btn-icon fs-4 p-0 text-dark" style="height: 20px;">
                                    <i class="ri-arrow-left-s-line align-middle"></i>
                                </button>
                                <h4 class="card-title text-center fw-bold my-0">
                                    Tahun <span id="year"></span>
                                </h4>
                                <button type="button" id="next-year" class="_dm-iconButton btn btn-icon fs-4 p-0 text-dark" style="height: 20px;">
                                    <i class="ri-arrow-right-s-line align-middle"></i>
                                </button>
                            </div>
                            <div class="highchart" style="height: 300px;" id="chart-monthly-report"></div>
                        </div>
                        <div class="col-md-3">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th class="text-center">Laporan</th>
                                        <th class="text-center">Penyelesaian</th>
                                    </tr>
                                </thead>
                                <tbody id="reportrealizations"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagebreak"></div>
            <div class="card my-4" style="background-color: #25476a;">
                <div class="card-body py-3">
                    <div class="row">
                        @foreach ($stats as $index => $stat)
                            <div class="col-2 text-center py-3 @if($index+1 != count($stats)) border-inline @endif">
                                <h5 class="mb-0 text-white">
                                    Laporan <br>
                                    {{ $stat->name }}
                                </h5>
                                <h2 class="display-4 text-yellow mb-0">
                                    {{ $stat->total }}
                                </h2>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center fw-bold mb-0">
                        Tabel Laporan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Pelapor</th>
                                    <th>No. Laporan</th>
                                    <th class="text-center" style="width: 150px;">Status Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($complaintactivities as $index => $complaint)    
                                    <tr>
                                        <td class="text-center">
                                            {{ $index+1 }}
                                        </td>
                                        <td>
                                            {{$complaint->f_tanggal_masuk}}
                                        </td>
                                        <td>
                                            {{$complaint->f_nama}}
                                        </td>
                                        <td>
                                            {{$complaint->f_noreg}}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge" style="background: {{ $complaint->status->s_warna_background }}; color: {{ $complaint->status->s_warna_teks }};">
                                                {{ $complaint->status->s_nama }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/themify-icons.css') }}">
    <style>
        .btn-check:active+.btn:focus, .btn-check:checked+.btn:focus, .btn.active:focus, .btn:active:focus {
            box-shadow: none;
        }
        .table td {
            padding: 0.3rem 0.5rem!important;
            vertical-align: middle;
        }
        .pagebreak {
            page-break-after: always;
        }

        @page {
            margin: 1cm;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/dashboard/js/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/highcharts/data.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/highcharts/drilldown.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/highcharts/export-data.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/highcharts/exporting.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('helpers/js/formathelper.js') }}"></script>
    <script>
        var year = formatDateYear();
        $('#year').html(year);
       
        var container =  "chart-monthly-report";
        var year = new Date().getFullYear();
        var title = "";
        var chartoptions = {
            chart: {
                renderTo: container,
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [],
                type: 'category'
            },  
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Jumlah Laporan'
                }
            },
            tooltip: { 
                enabled: false 
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    },
                    pointPadding: 0.01,
                    states: {
                        hover: {
                            enabled: false
                        }
                    }
                }
            },
            series: [{
                name: "Jumlah Laporan",
                data: [],
                color: '#25476a',
                
            }]
        };

        var chart = updateChart();
        
        function updateChart() {
            $('#reportrealizations tr').remove();
            $.ajax({
                type: "POST",
                url: "{{route('getchart')}}",
                data: {
                    _token:"{{csrf_token()}}",
                    year:$('#year').html()
                },
                dataType: "json",
                success: function (response) {
                    chartoptions.xAxis.categories = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    chartoptions.series = [
                        {
                            name: 'Laporan Masuk',
                            color: '#5994cf',
                            data: response.laporan_masuk
                        },
                        {
                            name: 'Laporan Selesai',
                            color: '#25476a',
                            data: response.laporan_selesai
                        }
                    ];
                    chartoptions.yAxis.title.text = 'Jumlah Laporan';
                    chart = new Highcharts.Chart(chartoptions);

                    response.reportrealizations.forEach(element => {
                        $('#reportrealizations').append(`
                        <tr>
                            <td class="py-2">
                                ` + element.month + `
                            </td>
                            <td class="py-2 text-center">
                                ` + element.total + `
                            </td>
                            <td class="py-2 text-center">
                                ` + element.percentage + ` %
                            </td>
                        </tr>
                        `);
                    });
                }
            }); 
        }

        $('#previous-year').on('click',function (e) { 
            e.preventDefault();
            var year = $('#year').html();
            var next = parseInt(year)-1;
            $('#year').html(next);
            updateChart();
         });

        $('#next-year').on('click',function (e) { 
            e.preventDefault();
            var year = $('#year').html();
            var next = parseInt(year)+1;
            $('#year').html(next);
            updateChart();
         });
    </script>
@endsection