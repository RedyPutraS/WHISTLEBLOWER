@extends('front.master.base')

@section('content')
    <article class="post-63 page type-page status-publish hentry">
        <div class="entry-content container">
            <div class="row pb-5">
                <div class="col-md-8">
                    <div class="d-inline-block">
                        <h4 class="vc_custom_heading mr-2">
                            @if ($cms['Judul'])
                                {!! $cms['Judul'] !!}
                            @else
                                Status Pengaduan
                            @endif
                            No. {{ $report->f_noreg }} :
                        </h4>
                    </div>
                    <div class="d-inline-block">
                        <h4 class="d-sm-block">
                            <span class="text-uppercase py-2 px-5" style="background: {{ $report->status->s_warna_background }}; color: {{ $report->status->s_warna_teks }};">
                                {{ $report->status->s_nama }}
                            </span>
                        </h4>
                    </div>
                    <div>
                        @if ($cms['Isi'])
                            {!! $cms['Isi'] !!}
                        @else
                            <p>
                                Laporan Bapak/Ibu telah kami terima dan akan kami tindak lanjuti.
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 text-lg-right">
                    <input type="hidden" name="f_token" id="f_token" value="{{ $report->f_token }}">
                    <div class="my-2">
                        <button type="button" id="detailreport" class="cmt-vc_general cmt-vc_btn3 btn-main-outline" style="min-width: 175px;">
                            Detail Pengaduan
                        </button>
                    </div>
                    <div class="my-2">
                        <button type="button" id="askquestion" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-black" style="min-width: 175px;">
                            Tanya Investigator
                        </button>
                    </div>
                </div>
            </div>
            @if (Session::has('success'))
                <hr>
                <div class="py-3">
                    <h4 class="vc_custom_heading mr-2">
                        Bukti Tambahan Telah Diterima
                    </h4>
                    <p>
                        Kami ucapkan terima kasih atas partisipasi bapak/ibu telah membuat laporan pengaduan di MNK Whistleblower system.
                    </p>
                    <div class="my-2 row justify-content-center">
                        <div class="col-md-5 mx-auto">
                            <div class="row align-items-center py-3 py-lg-1">
                                <div class="col-lg-5 text-lg-right">
                                    <label class="my-0">
                                        Nomor Laporan :
                                    </label>
                                </div>
                                <div class="col-lg-7">
                                    <div class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3-color-skincolor w-100 font-weight-bold">
                                        {{ $report->f_noreg }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>
                        Status dapat diakses melalui nomor laporan.
                    </p>
                </div>
            @endif
            <hr>
            <div class="mb-5">
                @if ($cms['Keterangan'])
                    {!! $cms['Keterangan'] !!}
                @else
                    <p>
                        Bapak ibu juga dapat melampirkan bukti atau keterangan tambahan untuk laporan ini.
                    </p>
                @endif
            </div>
            <div>
                <form action="{{ route('uploadevidence', Crypt::encrypt($report->f_id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row align-items-center">
                                <div class="col-11">
                                    <label>
                                        Tambah Bukti/Keterangan
                                    </label>
                                    <p class="small">
                                        Dapat berupa dokumen, foto, video dan audio. Ukuran file maksimal {{ $filesizelimit }}kb!
                                    </p>
                                </div>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="w-100">
                                <button type="button" class="btn btn-flat btn-square mr-2" id="createEvidence">
                                    <i class="fa fa-fw fa-plus"></i>
                                </button>
                                <label>
                                    Tambah Bukti
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="my-4">
                        <div class="border p-4 hide" id="evidence-box">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-11">
                                            Keterangan Tambahan
                                        </label>
                                        <div class="col-1 d-none d-lg-block font-weight-bold">
                                            :
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    @error('fb_keterangan')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <textarea name="fb_keterangan" id="fb_keterangan" class="form-control" rows="4">{{ old('fb_keterangan') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <div class="col-11">
                                            <label>
                                                Unggah Bukti
                                            </label>
                                            <p class="small">
                                                Dapat berupa dokumen, foto, video dan audio
                                            </p>
                                        </div>
                                        <div class="col-1 d-none d-lg-block font-weight-bold">
                                            :
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center file-evidence">
                                        <div style="min-width: 30px;">
                                            <label class="file-evidence-number h4">
                                                1.
                                            </label>
                                        </div>
                                        <div class="w-100">
                                            <input type="file" name="fb_file_bukti[]" class="form-control-file" required>
                                            @error('fb_file_bukti')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <label class="file-evidence-number-current mr-4 h4">
                                            2.
                                        </label>
                                        <div class="w-100">
                                        <button type="button" class="btn btn-flat btn-square mr-2" id="addEvidence">
                                                <i class="fa fa-fw fa-plus"></i>
                                            </button>
                                            <label>
                                                Tambah Bukti
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 text-right">
                                <div class="mb-2">
                                    {!! NoCaptcha::display() !!}
                                    {!! NoCaptcha::renderJs() !!}
                                </div>
                                <div>
                                    <button type="submit" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-skincolor">
                                        Tambahkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mt-5 text-right">
                    <a href="{{ route('index') }}" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-black">
                        Back to Home
                    </a>
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
            </div>
    </article>
@endsection

@section('css')
    <style>
        .g-recaptcha div {
            margin-left: auto;
        }
    </style>
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

        $('#createEvidence').on('click', function () {
            $('#evidence-box').toggleClass('hide');
        });

        var number = 1;
        var lastnumber = 2;
        $('#addEvidence').on('click', function () {
            number++;
            lastnumber++;
            
            $('.file-evidence-number-current').text(lastnumber+".");
            $('.file-evidence:first').clone().find('.file-evidence-number').text(number+".").end().find('input').val('').end().insertAfter(".file-evidence:last");
        });
    </script>
@endsection