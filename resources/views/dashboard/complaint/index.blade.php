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
                    <li class="breadcrumb-item active" aria-current="page">
                        Pengaduan
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Pengaduan
            </h1>
            <p class="lead">
                Data pengaduan yang masuk
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8 my-1">
                                    <h4 class="fw-bold mb-0 text-primary">
                                        Pengaduan
                                    </h4>
                                </div>
                                <div class="col-xl-4 text-lg-right my-1">
                                    @if (Auth::user()->can('Add Complaint'))
                                        <button type="button" onclick="addModal()" class="btn btn-primary btn-lg fw-bold">
                                            <i class="bx bx-plus-circle align-middle fs-4 me-1"></i>
                                            Input Pengaduan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <select name="filter_status" id="filter_status" class="form-select">
                                        <option value="">Semua Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->s_nama }}">{{ $status->s_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" name="filter_date" id="filter_date" class="form-control" placeholder="Pilih Tanggal Masuk">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dataTable dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:30px;">No.</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Pelapor</th>
                                            <th>No. Laporan</th>
                                            <th>Media Pelapor</th>
                                            <th class="text-center" style="width:100px;">Status Terakhir</th>
                                            <th style="width:50px;">Aksi</th>
                                            <th class="d-none"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($complaints as $index => $complaint)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $index+1 }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($complaint->f_tanggal_masuk)->translatedFormat('d F Y') }}
                                                    @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($complaint->created_at)->addDay($expiredday)) && $complaint->status->s_urutan == 3)
                                                        <span class="badge bg-danger ms-2">
                                                            Deadline Tindak Lanjut
                                                        </span>
                                                    @elseif (\Carbon\Carbon::parse($complaint->created_at)->subDay()->diffInDays(\Carbon\Carbon::now()) >= $expiredday && $complaint->status->s_urutan == 3)
                                                        <span class="badge bg-warning ms-2">
                                                            H-1 Deadline Tindak Lanjut
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $complaint->f_nama }}
                                                </td>
                                                <td>
                                                    {{ $complaint->f_noreg }}
                                                </td>
                                                <td>
                                                    {{ $complaint->f_sumber }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge" style="background: {{ $complaint->status->s_warna_background }}; color: {{ $complaint->status->s_warna_teks }};">
                                                        {{ $complaint->status->s_nama }}
                                                    </span>
                                                </td>
                                                <td class="text-center column_action">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" onclick="detailModal('{{Crypt::encrypt($complaint->f_id)}}')" class="btn btn-sm btn-icon btn-bg-light btn-icon-success" title="Lihat" target="_blank">
                                                            <i class="ri-eye-fill"></i>
                                                        </button>  
                                                        <a href='{{ route('complaint.print', Crypt::encrypt($complaint->f_id)) }}' class="btn btn-sm btn-icon btn-bg-light btn-icon-success" title="Cetak Berkas Pengaduan" target="_blank">
                                                            <i class="ri-printer-fill"></i>
                                                        </a>  
                                                        @if (Auth::user()->can('Edit Complaint'))   
                                                            @if (in_array($complaint->status->s_urutan, [1,4,5,6]))
                                                                <button type="button" onclick="initialInvestigationModal('{{ Crypt::encrypt($complaint->f_id)}}')" class="btn btn-sm btn-icon btn-bg-light btn-icon-success" title="Balas Pengaduan">
                                                                    <i class="ri-file-edit-fill"></i>
                                                                </button>
                                                            @elseif (in_array($complaint->status->s_urutan, [3]))
                                                                <button type="button" onclick="investigationModal('{{Crypt::encrypt($complaint->f_id)}}')" class="btn btn-sm btn-icon btn-bg-light btn-icon-success" title="Balas Pengaduan">
                                                                    <i class="ri-file-edit-fill"></i>
                                                                </button>
                                                            @endif                                         
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="d-none">
                                                    {{ $complaint->f_tanggal_masuk }}
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
        </div>
    </div>

    {{-- Modal Penyelidikan --}}
    <div id="initial-investigation-modal" class="modal fade" tabindex="-1" aria-labelledby="initial-investigation-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="initial-investigation-modal-label">
                        Ubah Status [Tahap Penyelidikan]
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('complaint.initialinvestigation', 1) }}" method="post" id="initial-investigation-modal-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">
                                Bukti
                                <span class="text-danger">*</span>
                            </label>
                            <select name="fr_status" id="fr_status" class="form-select">
                                <option value="Memadai">Memadai</option>
                                <option value="Tidak Memadai">Tidak Memadai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Keterangan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="fr_keterangan" id="fr_keterangan" rows="10" class="form-control ckeditor"></textarea>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn py-2 btn-primary fw-bold">
                                <i class="bx bx-save align-middle fs-4 me-1"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Penyidikan --}}
    <div id="investigation-modal" class="modal fade" tabindex="-1" aria-labelledby="investigation-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="investigation-modal-label">
                        Ubah Status [Tahap Penyidikan]
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('complaint.investigation', 1) }}" method="post" id="investigation-modal-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">
                                Hasil Investigasi
                                <span class="text-danger">*</span>
                            </label>
                            <select name="fr_status" id="fr_status" class="form-select">
                                <option value="Terbukti">Terbukti</option>
                                <option value="Tidak Terbukti">Tidak Terbukti</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Keterangan & Tindak Lanjut
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="fr_keterangan" id="fr_keterangan" rows="10" class="form-control ckeditor"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Unggah hasil investigasi 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" accept=".pdf,.doc,.docx" name="fr_file_bukti_investigasi" id="fr_file_bukti_investigasi" class="form-control">
                            <small>Hanya menerima file PDF, Doc, dan Docx</small>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn py-2 btn-primary fw-bold">
                                <i class="bx bx-save align-middle fs-4 me-1"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Data --}}
    <div id="form-modal" class="modal fade" tabindex="-1" aria-labelledby="form-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('complaint.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="_method" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-modal-label">
                            Tambah Pengaduan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">
                                Media Pelapor
                                <span class="text-danger">*</span>
                            </label>
                            <select name="f_sumber" id="f_sumber" class="form-select">
                                @foreach ($medias as $media)
                                    <option value="{{ $media }}">{{ $media }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Nama & Instansi Pelapor
                            </label>
                            <input type="text" name="f_nama" id="f_nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                No. Telepon/HP
                            </label>
                            <input type="text" name="f_no_telepon" id="f_no_telepon" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Email
                            </label>
                            <input type="text" name="f_email" id="f_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Waktu Kejadian
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="f_waktu_kejadian" id="f_waktu_kejadian" class="form-control">
                            <small>Waktu diisi secara detail, contoh: Hari Senin 20 Desember 2022 pukul 17:00</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Tempat Kejadian
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="f_tempat_kejadian" id="f_tempat_kejadian" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Kronologi
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="f_kronologi" id="f_kronologi" rows="10" class="form-control ckeditor"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Unggah Bukti
                            </label>
                            <p class="small">
                                Dapat berupa dokumen, foto, video dan audio. Ukuran file maksimal {{ $filesizelimit }}kb!
                            </p>
                            <div class="mt-3">
                                <div class="d-flex align-items-center file-evidence mb-2">
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
                                    <div style="min-width: 30px;">
                                        <label class="file-evidence-number-current mr-4 h4">
                                            2.
                                        </label>
                                    </div>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-info btn-sm btn-icon rounded-circle me-1" id="addEvidence">
                                            <i class="bx bx-plus-circle"></i>
                                        </button>
                                        <label>
                                            Tambah Bukti
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark fw-bold" data-bs-dismiss="modal">
                            <i class="bx bx-revision align-middle fs-4 me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="bx bxs-save align-middle fs-4 me-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Detail Data --}}
    <div id="detail-modal" class="modal fade" tabindex="-1" aria-labelledby="detail-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <input type="hidden" name="_method" id="_method" value="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail-modal-label">
                        Detail Pengaduan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Nama & Instansi Pelapor:
                                </p>
                                <div id="f_nama_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    No. Telepon/HP:
                                </p>
                                <div id="f_no_telepon_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Email:
                                </p>
                                <div id="f_email_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Waktu Kejadian:
                                </p>
                                <div id="f_waktu_kejadian_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Tempat Kejadian:
                                </p>
                                <div id="f_tempat_kejadian_detail"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    No Laporan:
                                </p>
                                <div id="f_noreg_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Token:
                                </p>
                                <div id="f_token_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Tanggal Masuk:
                                </p>
                                <div id="f_tanggal_masuk_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Media Pelapor:
                                </p>
                                <div id="f_sumber_detail"></div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0 fw-bold">
                                    Status Saat Ini:
                                </p>
                                <div id="f_status_detail"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <p class="mb-0 fw-bold">
                            Kronologi:
                        </p>
                        <div id="f_kronologi_detail"></div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <p class="mb-0 fw-bold">
                            Barang Bukti:
                        </p>
                        <div id="f_bukti_detail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datetimepicker.min.css') }}">
    <style>
        .ck-content {
            height: 340px!important;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/dashboard/js/datatables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.colvis.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.jszip.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('helpers/js/clientsidedatatables.js') }}"></script>
    <script src="{{ asset('helpers/js/formathelper.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('.ckeditor');
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.removeFormatAttributes = '';
    </script>
    <script>
        var table = $("#datatable").DataTable({
            responsive: true,
            stateSave: true,
            paging: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Show All"],
            ],
            dom: "<'row mb-3'B>" +
                  "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: "excel",
                    text: '<i class="ri-file-excel-2-line align-middle me-1"></i> Export to Excel',
                    titleAttr: "Export to Excel",
                    className: "btn btn-info my-1 mr-1",
                    exportOptions: {
                        columns: ":not(.column_action)",
                    },
                },
                {
                    extend: "copyHtml5",
                    text: '<i class="ri-file-copy-2-line align-middle me-1"></i> Copy to Clipboard',
                    titleAttr: "Copy to clipboard",
                    className: "btn btn-info my-1 mr-1",
                    exportOptions: {
                        columns: ":not(.column_action)",
                    },
                }
            ],
            stateSaveParams: function (settings, data) {
                data.status = $('#filter_status').val();
                data.date = $('#filter_date').val();
            },
            stateLoadParams: function (settings, data) {
                $('#filter_status').val(data.status);
                $('#filter_date').val(data.date);
            },
        });

        $('#filter_status').on('click', function() {
            var keyword = $(this).val();
            table.column(5).search(keyword).draw();
        });

        const datepicker = MCDatepicker.create({
            el: '#filter_date',
            dateFormat: 'YYYY-MM-DD',
            autoClose: true
        });
        datepicker.onSelect(
            (date, formatedDate) => table.column(7).search(formatedDate).draw()
        );
        datepicker.onClear(
            function() {
                table.column(7).search("").draw();
                MCDatepicker.close();
            }
        );
    </script>
    <script>
        function initialInvestigationModal(id) {
            var url = "{{route('complaint.initialinvestigation', ':id')}}";
            url = url.replace(':id',id);
            $('#initial-investigation-modal-form').attr('action',url);
            $("#initial-investigation-modal").modal('show'); // Show up modal
        }

        function investigationModal(id) {
            var url = "{{route('complaint.investigation', ':id')}}";
            url = url.replace(':id',id);
            $('#investigation-modal-form').attr('action',url);
            $("#investigation-modal").modal('show'); // Show up modal
        }

        function addModal() {
            $('input').val();
            $('#_token').val('{{ csrf_token() }}');
            $("#form-modal").modal('show'); // Show up modal
            $("#form-modal-label").text('Tambah Pengaduan'); // Change modal title
        }

        function detailModal(id) {
            var url = "{{ route('complaint.getdata',':param') }}";
            url = url.replace(':param',id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    $('#f_noreg_detail').html(response.f_noreg);
                    $('#f_token_detail').html(response.f_token);
                    $('#f_tanggal_masuk_detail').html(formatDateTime(response.created_at));

                    if (response.f_nama) {
                        $('#f_nama_detail').html(response.f_nama);
                    }
                    else {
                        $('#f_nama_detail').html("Anonim [Identitas Dirahasiakan]");
                    }

                    if (response.f_no_telepon) {
                        $('#f_no_telepon_detail').html(response.f_no_telepon);
                    }
                    else {
                        $('#f_no_telepon_detail').html("Anonim [Identitas Dirahasiakan]");
                    }

                    if (response.f_email) {
                        $('#f_email_detail').html(response.f_email);
                    }
                    else {
                        $('#f_email_detail').html("Anonim [Identitas Dirahasiakan]");
                    }

                    $('#f_status_detail').html(`
                        <span class="badge" style="background: ` + response.status.s_warna_background + `; color: ` + response.status.s_warna_teks + `;">
                            ` + response.status.s_nama + `
                        </span>
                    `);
                    $('#f_waktu_kejadian_detail').html(response.f_waktu_kejadian);
                    $('#f_tempat_kejadian_detail').html(response.f_tempat_kejadian);
                    $('#f_sumber_detail').html(response.f_sumber);
                    $('#f_kronologi_detail').html(response.f_kronologi);

                    if("{{ Auth::user()->can('Manage Complaint') }}"){
                        if (response.formulirpengaduan_bukti.length > 0) {
                            var html = '<ol type="1" class="ps-3">';
    
                            response.formulirpengaduan_bukti.forEach(bukti => {
                                html += `
                                    <li class="my-1">
                                        <a href="` + bukti.attachment + `" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="ri-eye-line align-middle me-1"></i>
                                            Lihat Bukti
                                        </a>
                                        <p class="mb-0 mt-2">
                                            Keterangan: ` + (bukti.fb_keterangan ? bukti.fb_keterangan : `-`) + `
                                        </p>
                                        <p class="my-0">
                                            Terakhir diunggah: ` + formatDateTime(bukti.created_at) + `
                                        </p>
                                    </li>`;
                            });
    
                            html += '</ol>';
                            
                            $('#f_bukti_detail').html(html);
                        }
                        else {
                            $('#f_bukti_detail').html(`<div class="badge bg-danger text-white">Bukti tidak diunggah</div>`);
                        }
                    }
                    else{
                        $('#f_bukti_detail').html(`<div>-</div>`);
                    }    
                }
            });
            $('#detail-modal').modal('show');
        }
    </script>
    <script>
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