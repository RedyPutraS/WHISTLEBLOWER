@extends('front.master.base')

@section('content')
    <article class="post-63 page type-page status-publish hentry">
        <div class="entry-content container">
            <ul class="nav nav-tabs">
                <li class="nav-item active">
                    <a id="detailreport" class="nav-link" aria-current="page" >
                        Detail
                    </a>
                </li>
                <li class="nav-item">
                    <a id="resultreport" class="nav-link">
                        Progress
                    </a>
                </li>
                <li class="nav-item">
                    <a id="askquestion" class="nav-link">
                        Tanya Tim
                    </a>
                </li>
            </ul>
            <div class="tab-content clearfix py-5">
                <div class="tab-pane active" id="1a">
                    <div class="row">
                        <div class="col-md-9 my-2">
                            <h4 class="vc_custom_heading">
                                @if ($cms['Judul'])
                                    {!! $cms['Judul'] !!}
                                @else
                                    Rincian Pengaduan
                                @endif
                                No. {{ $report->f_noreg }}
                            </h4>
                            
                            <div class="my-2">
                                <div class="row my-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="col-10">
                                                Nama & Instansi Pelapor
                                            </label>
                                            <div class="col-2 d-none d-lg-block font-weight-bold">
                                                :
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        @if ($report->f_nama)
                                            {{ $report->f_nama }}
                                        @else
                                            Anonim [Identitas Dirahasiakan]
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="col-10">
                                                No. Telepon/HP
                                            </label>
                                            <div class="col-2 d-none d-lg-block font-weight-bold">
                                                :
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        @if ($report->f_no_telepon)
                                            {{ $report->f_no_telepon }}
                                        @else
                                            Anonim [Identitas Dirahasiakan]
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="col-10">
                                                Email
                                            </label>
                                            <div class="col-2 d-none d-lg-block font-weight-bold">
                                                :
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        @if ($report->f_email)
                                            {{ $report->f_email }}
                                        @else
                                            Anonim [Identitas Dirahasiakan]
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="col-10">
                                                Waktu Kejadian
                                            </label>
                                            <div class="col-2 d-none d-lg-block font-weight-bold">
                                                :
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $report->f_waktu_kejadian }}
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="col-10">
                                                Tempat Kejadian
                                            </label>
                                            <div class="col-2 d-none d-lg-block font-weight-bold">
                                                :
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $report->f_tempat_kejadian }}
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="col-10">
                                                Kronologi
                                            </label>
                                            <div class="col-2 d-none d-lg-block font-weight-bold">
                                                :
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        {!! $report->f_kronologi !!}
                                    </div>
                                </div>
                                @if (count($report->formulirpengaduan_buktiawal) > 0)
                                    <div class="row my-2">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label class="col-10">
                                                    Bukti Awal
                                                </label>
                                                <div class="col-2 d-none d-lg-block font-weight-bold">
                                                    :
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <ol type="1" class="pl-3">
                                                @foreach ($report->formulirpengaduan_buktiawal as $index => $evidence)
                                                    <li class="mb-4">
                                                        <a href="{{ $evidence->attachment }}" target="_blank" class="btn btn-flat" style="font-size: 12px;">
                                                            <i class="fa fa-fw fa-eye mr-1"></i>
                                                            Bukti {{ $index+1 }}
                                                        </a>
                                                        <p class="my-0">
                                                            Keterangan: {!! $evidence->fb_keterangan ? $evidence->fb_keterangan : "-" !!}
                                                        </p>
                                                        <p class="my-0">
                                                            Terakhir diunggah: {{ \Carbon\Carbon::parse($evidence->created_at)->translatedFormat('d F Y H:i') }}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                @endif
                                @if (count($report->formulirpengaduan_buktitambahan) > 0)
                                    @foreach ($report->formulirpengaduan_buktitambahan as $index => $evidence)
                                        <hr>
                                        <div class="row my-2">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <label class="col-10">
                                                        Bukti Tambahan
                                                    </label>
                                                    <div class="col-2 d-none d-lg-block font-weight-bold">
                                                        :
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <a href="{{ $evidence->attachment }}" target="_blank" class="btn btn-flat" style="font-size: 12px;">
                                                    <i class="fa fa-fw fa-eye mr-1"></i>
                                                    Bukti {{ $index+1 }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <label class="col-10">
                                                        Keterangan Tambahan
                                                    </label>
                                                    <div class="col-2 d-none d-lg-block font-weight-bold">
                                                        :
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                @if ($evidence->fb_keterangan)
                                                    {!! $evidence->fb_keterangan !!} <br>
                                                    Terakhir diunggah: {{ \Carbon\Carbon::parse($evidence->created_at)->translatedFormat('d F Y H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 my-2">
                            <div class="p-3 w-100 font-weight-bold text-center" style="background: {{ $report->status->s_warna_background }}; color: {{ $report->status->s_warna_teks }};">
                                {{ $report->status->s_nama }} <br>
                                {{ \Carbon\Carbon::parse($report->formulirpengaduan_riwayatterbaru->created_at)->translatedFormat('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <div class="modal fade" id="form-modal-evidence" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-4" id="evidence">
                    <p><strong>Lihat Bukti</strong></p>
                </div>
                <div class="modal-footer">
                    <div class="mt-4 pull-right d-flex">
                        <button type="button" class="close-evidence btn btn-danger px-4 mr-2" style="min-width:70px;font-size: 1.5rem!important;">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="form-modal-token" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <form action="#" method="post" id="showbuktiform">
                        <div class="form-group">
                            <label>
                                Masukkan Token
                            </label>
                            <input type="hidden" id="action" name="action" value="">
                            <input type="text" name="f_token" id="f_token" value="">
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
    </div>
@endsection

@section('js')
<script src="{{ asset('helpers/js/fronthelpers.js') }}"></script>
<script>
    var checksession =  checksession(token,checkurl,"{{$report->f_noreg}}");
    $('#detailreport').on('click',function (e) { 
        e.preventDefault();
        $('#action').val('detailreport');
        if(checksession.success){
            $('#f_token').val(checksession.data);
            urlref();
        }else{
            $('#form-modal-token').toggleClass('show');
        }
    });

    $('#resultreport').on('click',function (e) { 
        e.preventDefault();
        $('#action').val('resultreport');
        if(checksession.success){
            $('#f_token').val(checksession.data);
            urlref();
        }else{
            $('#form-modal-token').toggleClass('show');
        }
    });

    $('#askquestion').on('click',function (e) { 
        e.preventDefault();
        $('#action').val('askquestion');
        if(checksession.success){
            $('#f_token').val(checksession.data);
            urlref();
        }else{
            $('#form-modal-token').toggleClass('show');
        }
        });

        $('#submit').on('click',function (e) { 
        e.preventDefault();
        urlref();
    });

    function urlref() { 
        var f_noreg = "{{ $report->f_noreg }}";
        var f_token = $('#f_token').val();
        var action = $('#action').val();

        $.ajax({
            type: "POST",
            url: "{{route('tokenverification')}}",
            data: {
                _token:'{{csrf_token()}}',
                f_token:f_token,
                f_noreg:f_noreg,
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
    }

</script>
    
@endsection