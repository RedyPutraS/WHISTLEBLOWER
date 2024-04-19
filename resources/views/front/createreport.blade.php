@extends('front.master.base')

@section('content')
    <article class="post-63 page type-page status-publish hentry">
        <div class="entry-content container">
            <div class="pb-5">
                @if ($cms['Kata Pengantar'])
                    {!! $cms['Kata Pengantar'] !!}
                @else
                    <h4 class="vc_custom_heading">
                        Form Pengaduan
                    </h4>
                    <p>
                        Jangan khawatir! Kami akan menjamin kerahasiaan identitas diri anda sebagai whistleblower. Laporan dapat disampaikan dengan nama samaran/alias.
                    </p>
                @endif
            </div>
            <div class="my-3">
                <form action="{{ route('storereport') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Instansi Pelapor *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select name="f_instansi_pelapor_1" id="f_instansi_pelapor_1" class="form-control">
                                <option value="">Pilih Instansi Pelapor</option>
                                <option value="Internal - AIR" {{ old('f_instansi_pelapor_1') == 'Internal - AIR' ? 'selected' : '' }}>Internal - AIR</option>
                                <option value="Internal - MNK" {{ old('f_instansi_pelapor_1') == 'Internal - MNK' ? 'selected' : '' }}>Internal - MNK</option>
                                <option value="Internal - BN" {{ old('f_instansi_pelapor_1') == 'Internal - BN' ? 'selected' : '' }}>Internal - BN</option>
                                <option value="Internal - ILBB" {{ old('f_instansi_pelapor_1') == 'Internal - ILBB' ? 'selected' : '' }}>Internal - ILBB</option>
                                <option value="Internal - Other" {{ old('f_instansi_pelapor_1') == 'Internal - Other' ? 'selected' : '' }}>Internal - Other</option>
                                <option value="Eksternal" {{ old('f_instansi_pelapor_1') == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                            </select>
                            @error('f_instansi_pelapor_1')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Nama *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="f_nama" id="f_nama" class="form-control" value="{{ old('f_nama') }}">
                            @error('f_nama')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    No. Telepon/HP *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="tel" name="f_no_telepon" id="f_no_telepon" class="form-control" value="{{ old('f_no_telepon') }}">
                            @error('f_no_telepon')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Email *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="f_email" id="f_email" class="form-control" value="{{ old('f_email') }}">
                            @error('f_email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="my-3">
                        <p class="mb-0">
                            *) bila tidak berkenan, dapat dikosongkan
                        </p>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Nama yang dilaporkan *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="f_nama_dilaporkan" id="f_nama_dilaporkan" class="form-control" value="{{ old('f_nama_dilaporkan') }}">
                            @error('f_nama_dilaporkan')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Instansi Pelapor *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select name="f_instansi_pelapor_2" id="f_instansi_pelapor_2" class="form-control" onchange="checkOther(this)">
                                <option value="">Pilih Instansi Pelapor</option>
                                <option value="AIR" {{ old('f_instansi_pelapor_2') == 'AIR' ? 'selected' : '' }}>AIR</option>
                                <option value="MNK" {{ old('f_instansi_pelapor_2') == 'MNK' ? 'selected' : '' }}>MNK</option>
                                <option value="BN" {{ old('f_instansi_pelapor_2') == 'BN' ? 'selected' : '' }}>BN</option>
                                <option value="ILBB" {{ old('f_instansi_pelapor_2') == 'ILBB' ? 'selected' : '' }}>ILBB</option>
                                <option value="Other" {{ old('f_instansi_pelapor_2') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <input type="text" name="f_instansi_pelapor_2_other" id="f_instansi_pelapor_2_other" class="form-control mt-2" style="display: none;" value="{{ old('f_instansi_pelapor_2_other') }}" placeholder="Masukan Instansi">
                            @error('f_instansi_pelapor_2')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Jabatan *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select name="f_jabatan" id="f_jabatan" class="form-control" onchange="checkOtherJabatan(this)">
                                <option value="">Pilih Jabatan</option>
                                <option value="CEO" {{ old('f_jabatan') == 'CEO' ? 'selected' : '' }}>CEO</option>
                                <option value="Director" {{ old('f_jabatan') == 'Director' ? 'selected' : '' }}>Director</option>
                                <option value="GM / Head / Manager" {{ old('f_jabatan') == 'GM / Head / Manager' ? 'selected' : '' }}>GM / Head / Manager</option>
                                <option value="Supervisor / Superintendent / Staff " {{ old('f_jabatan') == 'Supervisor / Superintendent / Staff ' ? 'selected' : '' }}>Supervisor / Superintendent / Staff </option>
                                <option value="Other" {{ old('f_jabatan') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <input type="text" name="f_jabatan_other" id="f_jabatan_other" class="form-control mt-2" style="display: none;" value="{{ old('f_jabatan_other') }}" placeholder="include: security, coaster, driver, etc">
                            @error('f_jabatan')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Divisi *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select name="f_divisi" id="f_divisi" class="form-control">
                                <option value="">Pilih Divisi</option>
                                <option value="Divisi 1" {{ old('f_divisi') == 'Divisi 1' ? 'selected' : '' }}>Divisi 1</option>
                                <option value="Divisi 2" {{ old('f_divisi') == 'Divisi 2' ? 'selected' : '' }}>Divisi 2</option>
                                <option value="Divisi 3" {{ old('f_divisi') == 'Divisi 3' ? 'selected' : '' }}>Divisi 3</option>
                                <option value="Divisi 4" {{ old('f_divisi') == 'Divisi 4' ? 'selected' : '' }}>Divisi 4</option>
                            </select>
                            @error('f_divisi')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Jenis Pengaduan *)
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select name="f_jenis_pengaduan" id="f_jenis_pengaduan" class="form-control" onchange="checkOtherJenisPengaduan(this)">
                                <option value="">Pilih Jenis Pengaduan</option>
                                <option value="Fraud" {{ old('f_jenis_pengaduan') == 'Fraud' ? 'selected' : '' }}>Fraud</option>
                                <option value="Harassment" {{ old('f_jenis_pengaduan') == 'Harassment' ? 'selected' : '' }}>Harassment</option>
                                <option value="Culture / Code of Ethics" {{ old('f_jenis_pengaduan') == 'Culture / Code of Ethics' ? 'selected' : '' }}>Culture / Code of Ethics</option>
                                <option value="Other" {{ old('f_jenis_pengaduan') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <input type="text" name="f_jenis_pengaduan_other" id="f_jenis_pengaduan_other" class="form-control mt-2" style="display: none;" value="{{ old('f_jenis_pengaduan_other') }}" placeholder="Masukan Jenis Pengaduan">
                            @error('f_jenis_pengaduan')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Waktu Kejadian
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="f_waktu_kejadian" id="f_waktu_kejadian" class="form-control" value="{{ old('f_waktu_kejadian') }}">
                            <small class="text-muted">Waktu diisi secara detail, contoh: Hari Senin 20 Desember 2022 pukul 17:00</small>
                            @error('f_waktu_kejadian')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Tempat Kejadian
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="f_tempat_kejadian" id="f_tempat_kejadian" class="form-control" value="{{ old('f_tempat_kejadian') }}">
                            @error('f_tempat_kejadian')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="row">
                                <label class="col-11">
                                    Kronologi
                                </label>
                                <div class="col-1 d-none d-lg-block font-weight-bold">
                                    :
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <textarea name="f_kronologi" id="f_kronologi" class="form-control ckeditor" rows="7">{{ old('f_kronologi') }}</textarea>
                            @error('f_kronologi')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
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
                                        Dapat berupa dokumen, foto, video dan audio. Ukuran file maksimal {{ $filesizelimit }}kb!
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
                                    <input type="file" name="fb_file_bukti[]" class="form-control-file">
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
                    <div class="my-3 text-right pull-right">
                        <div class="mb-2">
                            {!! NoCaptcha::display() !!}
                            {!! NoCaptcha::renderJs() !!}
                        </div>
                        @error('g-recaptcha-response')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <button type="submit" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3-size-md btn-rounded-sm cmt-vc_btn3-style-flat cmt-vc_btn3-weight-no cmt-vc_btn3-color-skincolor" title="Buat Laporan">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </article>
@endsection

@section('css')
    <link href="{{ asset('assets/front/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .ck-content {
            height: 340px!important;
        }
        .cke_chrome {
            border: 1px solid rgba(252, 106, 32, 1)!important;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/front/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('.ckeditor');
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.removeFormatAttributes = '';
    </script>
    <script>
        function checkOther(select) {
            var otherInput = document.getElementById('f_instansi_pelapor_2_other');
            if (select.value === 'Other') {
                otherInput.style.display = 'block';
            } else {
                otherInput.style.display = 'none';
            }
        }

        function checkOtherJabatan(select) {
            var otherInput = document.getElementById('f_jabatan_other');
            if (select.value === 'Other') {
                otherInput.style.display = 'block';
            } else {
                otherInput.style.display = 'none';
            }
        }

        function checkOtherJenisPengaduan(select) {
            var otherInput = document.getElementById('f_jenis_pengaduan_other');
            if (select.value === 'Other') {
                otherInput.style.display = 'block';
            } else {
                otherInput.style.display = 'none';
            }
        }
    </script>

    <script>
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
