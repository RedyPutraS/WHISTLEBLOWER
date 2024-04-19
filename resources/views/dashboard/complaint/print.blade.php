@extends('dashboard.master.base')

@section('content')
    <div class="content__header content__boxed overlapping mb-4">
        <div class="content__wrap">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <i class="ri-home-4-line"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" >
                        Pengaduan
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Cetak Berkas
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Pengaduan
            </h1>
            <p class="lead">
                Cetak berkas pengaduan secara lengkap
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="bg-white p-3 mt-4 print-container">

                <div class="col-md-6 mx-auto mb-5">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-2 text-right">
                            <img src="{{ asset('assets/dashboard/images/logomnk.png') }}" height="75">
                        </div>
                        <div class="col-6">
                            <h2 class="font-weight-bold lh-1">
                                PT. Multi Nitrotama Kimia
                            </h2>
                            <h6 class="mb-1">
                                Jl. Jend. Sudirman Kav. 52-53 Lot 9, Jakarta, 12190
                            </h6>
                            <h6 class="mb-0">
                                Telp : (+62-21) 2903 5022 (Hunting) |
                                Fax : (+62-21) 2903 5021
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="text-center pb-4">
                    <h3 class="font-weight-bold mb-1">
                        Berkas Pengaduan
                    </h3>
                    <h6>
                        No. {{ $complaint->f_noreg }}
                    </h6>
                </div>

                <div class="pb-4">
                    <h4 class="font-weight-bold mb-3 underline">
                        <u>
                            Rincian Pengaduan :
                        </u>
                    </h4>
                    <ul class="ps-0 mb-4">
                        <li class="row">
                            <div class="col-3">
                                Nama & Instansi
                            </div>
                            <div class="col-9">
                                :
                                @if ($complaint->f_nama)
                                    {{ $complaint->f_nama }}
                                @else
                                    Anonim [Identitas Dirahasiakan]
                                @endif
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-3">
                                No. Telepon/HP
                            </div>
                            <div class="col-9">
                                :
                                @if ($complaint->f_no_telepon)
                                    {{ $complaint->f_no_telepon }}
                                @else
                                    Anonim [Identitas Dirahasiakan]
                                @endif
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-3">
                                Email
                            </div>
                            <div class="col-9">
                                :
                                @if ($complaint->f_email)
                                    {{ $complaint->f_email }}
                                @else
                                    Anonim [Identitas Dirahasiakan]
                                @endif
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-3">
                                Waktu Kejadian
                            </div>
                            <div class="col-9">
                                :
                                {{ $complaint->f_waktu_kejadian }}
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-3">
                                Tempat Kejadian
                            </div>
                            <div class="col-9">
                                :
                                {{ $complaint->f_tempat_kejadian }}
                            </div>
                        </li>
                    </ul>
                    <div class="text-justify mb-4">
                        <p class="mb-1">
                            Kronologi :
                        </p>
    
                        {!! $complaint->f_kronologi !!}
                    </div>
                    <div class="mb-4">
                        <p class="mb-1">
                            Bukti Awal:
                        </p>
                        @if (count($complaint->formulirpengaduan_buktiawal) > 0)
                            <ol type="1" class="ps-3">
                                @foreach ($complaint->formulirpengaduan_buktiawal as $index => $evidence)
                                    <li>
                                        {{ $evidence->attachment }}
                                        <p class="my-0">
                                            Keterangan: {!! $evidence->fb_keterangan ? $evidence->fb_keterangan : "-" !!}
                                        </p>
                                        <p class="my-0">
                                            Terakhir diunggah: {{ \Carbon\Carbon::parse($evidence->created_at)->translatedFormat('d F Y H:i') }}
                                        </p>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <div class="badge bg-danger text-white">Bukti tidak diunggah</div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <p class="mb-1">
                            Bukti Tambahan:
                        </p>
                        @if (count($complaint->formulirpengaduan_buktitambahan) > 0)
                            <ol type="1" class="ps-3">
                                @foreach ($complaint->formulirpengaduan_buktitambahan as $index => $evidence)
                                    <li>
                                        {{ $evidence->attachment }}
                                        <p class="my-0">
                                            Keterangan: {!! $evidence->fb_keterangan ? $evidence->fb_keterangan : "-" !!}
                                        </p>
                                        <p class="my-0">
                                            Terakhir diunggah: {{ \Carbon\Carbon::parse($evidence->created_at)->translatedFormat('d F Y H:i') }}
                                        </p>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <div class="badge bg-danger text-white">Bukti tidak diunggah</div>
                        @endif
                    </div>
                </div>

                <div class="pb-4">
                    <h4 class="font-weight-bold mb-3 underline">
                        <u>
                            Riwayat Perkembangan Pengaduan :
                        </u>
                    </h4>
                    <div class="timeline pb-4">
                        @foreach ($complaint->formulirpengaduan_riwayat as $history)
                            <div class="tl-entry active">
                                <div class="tl-time">
                                    <div class="tl-date">
                                        {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="tl-time">
                                        {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('H:i') }}
                                    </div>
                                </div>
                                <div class="tl-point"></div>
                                <div class="tl-content">
                                    {!! $history->fr_keterangan !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pb-4 pt-4 pagebreak">
                    <h4 class="font-weight-bold mb-3 underline">
                        <u>
                            Diskusi dengan Investigator :
                        </u>
                    </h4>
                    <div class="mt-4" id="chat-card">
                        @if (count($complaint->diskusi))
                            @foreach ($complaint->diskusi as $diskusi)
                                <div class="card my-4 shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="col-1 d-none d-lg-block">
                                                <i class="ri-user-3-fill" style="font-size: 25px;"></i>
                                            </div>
                                            <div class="col-11">
                                                <div class="row mb-4">
                                                    <div class="col-8">
                                                        <h5 class="mb-0">
                                                            {{ $diskusi->d_nama }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <h5 class="mb-0">
                                                            {{ \Carbon\Carbon::parse($diskusi->d_waktu)->translatedFormat('d F Y H:i') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{ $diskusi->rd_pesan }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h5 class="my-4">
                                Belum ada diskusi tanya jawab.
                            </h5>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .print-container div, .print-container p, .print-container h1, .print-container h2, .print-container h3, .print-container h4, .print-container h5, .print-container h6 {
            color: #373c43;
            font-weight: 500;
            font-family: "Work Sans", Arial, Helvetica, sans-serif;
        }

        @page {
            margin: 1cm;
        }
        
        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
            #exclude-from-print {
                display: none;
            }
        }
    </style>
@endsection

@section('js')
    <script>
        window.print();
    </script>
@endsection