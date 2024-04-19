@extends('front.master.base')

@section('breadcrumb')
    <div class="cmt-title-wrapper cmt-bg cmt-bgcolor-custom cmt-titlebar-align-default cmt-textcolor-white cmt-bgimage-yes cmt-breadcrumb-bgcolor-custom" @if ($cms['Gambar Banner']) style="background-image: url('{{ asset('storage/cms/'.$cms['Gambar Banner']) }}')" @endif>
        <div class="cmt-title-wrapper-bg-layer cmt-bg-layer"></div>
        <div class="cmt-titlebar entry-header">
            <div class="cmt-titlebar-inner-wrapper">
                <div class="cmt-titlebar-main">
                    <div class="container">
                        <div class="cmt-titlebar-main-inner">
                            <div class="entry-title-wrapper">
                                <div class="container">
                                    <h1 class="entry-title">
                                        Whistleblower
                                    </h1>
                                </div>
                            </div>
                            <div class="breadcrumb-wrapper">
                                <div class="container">
                                    <div class="breadcrumb-wrapper-inner">
                                        <span>
                                            <a title="Go to MNK." href="https://mnk.co.id/" class="home">
                                                <span>MNK</span>
                                            </a>
                                        </span>
                                        &gt;
                                        <span>
                                            <span class="post post-page current-item">
                                                Whistleblower
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <article class="post-63 page type-page status-publish hentry">
        <div class="entry-content container">
            <div class="pb-5">
                @if ($cms['Ucapan Selamat Datang'])
                    {!! $cms['Ucapan Selamat Datang'] !!}
                @else
                    <h4 class="vc_custom_heading">
                        Selamat datang di MNK Whistleblowing System
                    </h4>
                    <p>
                        MNK Whistleblowing System adalah aplikasi yang disediakan oleh PT. Multi Nitrotama Kimia bagi pihak eksternal dan internal perusahaan,  yang memiliki informasi dan ingin melaporkan suatu perbuatan berindikasi Fraud dan/atau pelanggaran yang terjadi di lingkungan perusahaan.
                    </p>
                    <p>
                        Anda tidak perlu khawatir terungkapnya identitas diri anda karena PT. Multi Nitrotama Kimia akan merahasiakan identitas diri anda sebagai whistleblower. PT. Multi Nitrotama Kimia menghargai informasi yang Anda laporkan. Fokus kami kepada materi informasi yang Anda Laporkan.
                    </p>
                @endif
            </div>
            <div class="py-5">
                @if ($cms['Kata Pengantar'])
                    {!! $cms['Kata Pengantar'] !!}
                @else
                    <h4 class="vc_custom_heading">
                        Penyampaian Pelaporan
                    </h4>
                    <p>
                        Dalam rangka mempermudah dan mempercepat proses tindak lanjut, pengaduan fraud dan/atau pelanggaran yang dilaporkan, sebaiknya dapat memenuhi informasi yang jelas dan dapat dipertanggungjawabkan serta dilengkapi dengan bukti yang relevan, kompeten dan cukup, diantaranya meliputi:
                    </p>
                    <ul>
                        <li>
                            <b>What:</b> Perbuatan berindikasi pelanggaran yang diketahui
                        </li>
                        <li>
                            <b>Where:</b> Dimana perbuatan tersebut dilakukan
                        </li>
                        <li>
                            <b>When:</b> Kapan perbuatan tersebut dilakukan
                        </li>
                        <li>
                            <b>Who:</b> Siapa saja yang terlibat dalam perbuatan tersebut
                        </li>
                        <li>
                            <b>How:</b> Bagaimana perbuatan tersebut dilakukan (modus, cara, bukti, kerugian, dsb.)
                        </li>
                    </ul>
                    <p>
                        Selain, dengan dashboard pada web ini pelaporan juga dapat langsung dikirimkan melalui email <b>pengaduan@mnk.co.id</b> dan whatsapp melalui nomor <b>+6281xxxxxxx</b>.
                    </p>                    
                @endif
            </div>
            <div class="my-3 text-right">
                <a class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3-size-md btn-rounded-sm cmt-vc_btn3-style-flat cmt-vc_btn3-weight-no cmt-vc_btn3-color-skincolor" href="{{ route('createreport') }}" title="Buat Laporan">
                    Buat Laporan
                </a>
            </div>
            <div class="py-5">
                @if ($cms['Tindak Lanjut'])
                    {!! $cms['Tindak Lanjut'] !!}
                @else
                    <h4 class="vc_custom_heading">
                        Tindak Lanjut
                    </h4>
                    <p>
                        Apabila Bapak/Ibu ingin mengetahui status, perkembangan dan tindak lanjut atas laporan yang telah dibuat, dapat menginput nomor laporan pengaduan pada menu di bawah ini:
                    </p>
                @endif
            </div>
            <div class="my-2">
                <form action="{{route('tracereport')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-lg-2 my-2">
                            <label>
                                No. Laporan:
                            </label>
                        </div>
                        <div class="col-lg-8 my-2">
                            <input type="text" name="f_noreg_search" id="f_noreg_search" class="form-control">
                        </div>
                        <div class="col-lg-2 my-2">
                            <button type="submit" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3-size-md btn-rounded-sm cmt-vc_btn3-style-flat cmt-vc_btn3-weight-no cmt-vc_btn3-color-skincolor w-100" title="Lacak Laporan">
                                Lacak
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- <div class="modal fade" id="form-modal-token" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <form action="#" method="post" id="showbuktiform">
                            <div class="form-group">
                                <label>
                                    Masukkan Token
                                </label>
                                <input type="hidden" id="action" name="action" value="">
                                <input type="text" id="f_token" class="f_token" class="form-control">
                            </div>
                            <div class="mt-4 pull-right d-flex">
                                <button type="button" class="close btn btn-danger px-4 mr-2" style="min-width:70px;font-size: 1.5rem!important;">
                                    Tutup
                                </button>
                                <button type="button" id="submit" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-black" style="min-width:70px;">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

    </article>

@endsection

@section('js')
    <script>
        $('#tracingreport').on('click',function (e) { 
            e.preventDefault();
            $('#action').val('tracingreport');
            $('#form-modal-token').toggleClass('show');
         });

        $('#submit').on('click',function (e) { 
            e.preventDefault();
            var fb_id = $('#fb_id').val();
            var f_token = $('#f_token').val();
            var f_noreg = $('#f_noreg_search').val();
            var action = $('#action').val();
            
            $.ajax({
                type: "POST",
                url: "{{route('tokenverification')}}",
                data: {
                    _token:'{{csrf_token()}}',
                    f_token:f_token,
                    action:action
                },
                dataType: "json",
                success: function (response) {
                    if(response.result){
                        var url = response.data.url;
                        location.href = url; 
                    }else{
                        $('#form-modal-token').toggleClass('show');
                        $('#f_token').val('');
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
        });
    </script>
@endsection