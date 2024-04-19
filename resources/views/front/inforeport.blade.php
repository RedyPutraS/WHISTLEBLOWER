@extends('front.master.base')

@section('content')
    <article class="post-63 page type-page status-publish hentry">
        <div class="entry-content container">
            <div id="download-container" class="p-3">
                <div class="pb-5">
                    @if ($cms['Ucapan Terima Kasih'])
                        {!! $cms['Ucapan Terima Kasih'] !!}
                    @else
                        <h4 class="vc_custom_heading">
                            Pengaduan Telah Diterima
                        </h4>
                        <p>
                            Kami ucapkan terima kasih atas partisipasi bapak/ibu telah membuat laporan pengaduan di MNK Whistleblower system.
                        </p>
                    @endif
                </div>
                <div class="my-2 row justify-content-center">
                    <div class="col-md-5 mx-auto">
                        <div class="row align-items-center py-3 py-lg-1">
                            <div class="col-lg-5 text-lg-right">
                                <label class="my-0">
                                    Nomor Registrasi Laporan :
                                </label>
                            </div>
                            <div class="col-lg-7">
                                <div class="w-100 text-center py-3 font-weight-bold roboto-mono" style="background-color: rgba(252, 106, 32, 1); color: white;">
                                    {{ $report->f_noreg }}
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center py-3 py-lg-1">
                            <div class="col-lg-5 text-lg-right">
                                <label class="my-0">
                                    Token :
                                </label>
                            </div>
                            <div class="col-lg-7">
                                <div class="border-dark w-100 text-center py-3 font-weight-bold roboto-mono " style="background-color: white; color: #002c5b; box-sizing: border-box;">
                                    {{ $report->f_token }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    @if ($cms['Disclaimer'])
                        {!! $cms['Disclaimer'] !!}
                    @else
                        <p>
                            Bapak/Ibu dapat memantau progres tindak lanjut laporan pada menu sebelumnya dengan menginput nomor laporan tersebut. Isi laporan anda kami jamin kerahasiaannya dan akan kami tindak lanjuti sesuai peraturan dan ketentuan yang berlaku.
                        </p>
                        <p>
                            PT. Multi Nitrotama Kimia memiliki komitmen untuk menjalankan perusahaan secara profesional dengan berlandaskan pada perilaku perusahaan yang sesuai dengan Budaya Kerja dan sikap kerja perusahaan, khususnya nilai budaya Integritas.
                        </p>
                    @endif
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" id="download" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-black py-2 px-4" style="border-radius: 20px;">
                    <i class="ti ti-download mr-2"></i>
                    Unduh
                </button>
            </div>
            <div class="pt-5 text-right">
                <a href="{{ route('index') }}" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-black">
                    Back to Home
                </a>
            </div>
        </div>
    </article>
@endsection

@section('js') 
    <script src="{{ asset('assets/front/js/html2canvas.min.js') }}"></script>
    <script>
        $('#download').on('click', function () {
            html2canvas(document.getElementById("download-container"), {}).then(canvas => {
                var a = document.createElement('a');
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                a.download = 'Laporan {{ $report->f_noreg }}.jpg';
                a.click();
            });
        })
    </script>
@endsection