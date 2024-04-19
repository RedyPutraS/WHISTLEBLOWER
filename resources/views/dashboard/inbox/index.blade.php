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
                        Pengaduan via Email
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Pengaduan via Email
            </h1>
            <p class="lead">
                Pengaduan Masuk via Email
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="card">
                <div class="card-body">
                    <div class="flex-fill min-w-0" id="mail-list">
                        <div class="border-bottom pb-3 mb-3">
                            <h4 class="fw-bold">
                                Kotak Masuk Email
                            </h4>
                            <h6>
                                Email aktif saat ini: {{ $currentemail }}
                            </h6>
                        </div>
                        <div class="d-md-flex mb-3">
                            <div class="d-flex align-items-center align-middle justify-content-center mb-3">                
                                @if (Auth::user()->can('Manage Complaint'))
                                    <button onclick="synchronize()" class="btn btn-primary fw-bold">
                                        <i class="ri ri-refresh-line align-middle fs-5"></i>
                                        Sinkronkan
                                    </button>
                                @endif
                            </div>
                            <div class="ms-auto d-flex gap-3 align-items-center justify-content-center justify-content-md-end mb-3">
                                <span class="h6 m-0 pagenumber">
                                    <strong>1-50</strong>
                                    of
                                    <strong>160</strong>
                                </span>                
                                <div class="btn-group btn-group">
                                    <a href="#" class="btn btn-icon btn-outline-light prevpage">
                                        <i class="ri-arrow-left-s-line"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-outline-light nextpage">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </div>                
                            </div>
                        </div>
                        <div class="list-group list-group-borderless gap-1 mb-3" id="allmails">    
                            <div id="loader" class="text-center">
                                <div class="spinner-border text-primary avatar-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>           
                        </div>                
                        <div class="d-flex align-items-center justify-content-end border-top pt-3 gap-3">
                            <span class="h6 m-0 pagenumber"></span>                
                            <div class="btn-group btn-group">
                                <a href="#" class="btn btn-icon btn-outline-light prevpage">
                                    <i class="ri-arrow-left-s-line"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-outline-light nextpage">
                                    <i class="ri-arrow-right-s-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex-fill min-w-0 d-none" id="mail-detail"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidenav Convert Email ke Pengaduan --}}
    <div id="convertToComplaint" class="_dm-setting-container offcanvas offcanvas-end rounded-start" role="dialog" style="height: 100vh; max-width: 1000px;" data-focus="false">
        <div class="offcanvas-body h-auto" style="overflow-y: scroll;">
            <form action="{{ route('inbox.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="f_tanggal_masuk" id="f_tanggal_masuk">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Tambah Pengaduan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="complaint-form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark fw-bold" data-bs-dismiss="offcanvas">
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

    <!-- Modal -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loader"></div>
                    <div clas="loader-txt">
                        <p>Mohon tunggu sebentar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/dashboard/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('helpers/js/formathelper.js') }}"></script>
    <script>
        $(document).ready(function () {
            loadList();
        });

        function synchronize() { 
            Swal.fire({
                text: "Apakah anda ingin sinkronisasi pesan email ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#25476a',
                cancelButtonColor: '#808080',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loadMe').modal('show');
                        window.location.href = "{{route('inbox.synchronize')}}";
                    }
                })
         }

        function showOffcanvas(msgno) {
            var url = "{{ route('inbox.detailemail', ':msgno') }}";
            url = url.replace(':msgno', msgno);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        var html = `
                            <div class="form-group">
                                <label class="form-label">
                                    Nama & Instansi Pelapor
                                </label>
                                <input type="hidden" name="msgno" id="msgno" class="form-control" value="` + msgno + `">
                                <input type="text" name="f_nama" id="f_nama" class="form-control" value="` + response.data.pe_fromname + `">
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
                                <input type="text" name="f_email" id="f_email" class="form-control" value="` + response.data.pe_fromaddress + `" readonly>
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
                                <textarea name="f_kronologi" id="f_kronologi" rows="10" hidden>` + response.data.pe_messagebody + `</textarea>
                                <div class="border p-2">
                                    ` + response.data.pe_messagebody + `
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    Bukti Pengaduan
                                </label>
                                <input type="hidden" name="f_bukti" value="` + response.data.attachments + `">
                                <p>
                                    Bukti otomatis tersimpan sesuai dengan lampiran file pada email
                                </p>
                            </div>
                        `;

                        $('#complaint-form').html(html);
                    }
                }
            });

            $('#convertToComplaint').offcanvas('show');
        }

        function loadList(urlpagination = false) {
            var url = "{{ route('inbox.reademail') }}";  
            if (urlpagination) {
                url = urlpagination
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    $('#loader').empty();
                    $('#mail-list').removeClass('d-none');
                    $('#mail-detail').addClass('d-none');
                    $('#allmails').empty();
                    
                    if (response.totaldata > 0) {
                        $('.pagenumber').html(`
                            <strong> ` + response.startpage + `-` + response.endpage + ` </strong>
                            of
                            <strong> ` + response.totaldata + ` </strong>
                        `);
                        $('.nextpage').attr('href', response.nextpageurl);
                        $('.prevpage').attr('href', response.prevpageurl);
                        response.data.forEach(email => {
                            var html = `
                                <div class="list-group-item border list-group-item-action d-flex align-items-center">
                                    <div class="flex-fill min-w-0 ms-3">
                                        <div class="d-flex flex-wrap flex-xl-nowrap align-items-xl-center">
                                            <div class="w-md-300px flex-shrink-0">
                                                <a href="javascript:void(0);" onclick="loadDetail(` + email.pe_msgno + `)" class="h6 fw-normal m-0 text-decoration-none">
                                                    ` + email.pe_fromname + " (" + email.pe_fromaddress + `)  
                                                </a>
                                            </div>
                                            <div class="flex-shrink-0 ms-auto order-xl-3">
                            `;

                            if (email.is_generate_report == 1) {
                                html += `
                                                <span class="badge bg-info me-2">
                                                    Sudah Menjadi Laporan
                                                </span>
                                `
                            }

                            if (email.pe_attachment) {
                                html += `                                                
                                                <span class="me-2">
                                                    <i class="ri-attachment-2"></i>
                                                </span>
                                `;
                            }

                            html += `
                                            </div>
                                            <div class="flex-shrink-0 ms-auto order-xl-3">
                                                <small class="text-muted">
                                                    ` + formatDateTimeShort(email.pe_date)  + `
                                                </small>
                                            </div>
                                            <div class="flex-fill w-100 min-w-0 mt-2 mt-xl-0 mx-xl-3 order-xl-2">
                                                <a href="javascript:void(0);" onclick="loadDetail(` + email.pe_msgno + `)" class="d-block h6 fw-normal m-0 text-decoration-none text-truncate fw-bold">
                                                    ` + email.pe_subject  + ` 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            $('#allmails').append(html);
                        });
                    }
                    else {
                        $('#allmails').html(
                            `<p class="my-3">Belum ada pesan.</p>`
                        );
                    }
                }
            });
        }

        function loadDetail(msgno) {            
            var url = "{{ route('inbox.detailemail', ':msgno') }}";
            url = url.replace(':msgno', msgno);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    $('#loader').empty();
                    $('#mail-list').addClass('d-none');
                    $('#mail-detail').removeClass('d-none');
                    $('#mail-detail').empty();
                    
                    if (response.success) {
                        var html = `
                            <div class="flex-fill min-w-0">
                                <h1 class="h3 mb-0">
                                    ` + response.data.pe_subject + `
                                </h1>
                                <div class="d-md-flex mt-4">
                                    <div class="d-flex align-items-center mb-3 position-relative">
                                        <div class="flex-shrink-0">
                                            <img class="img-sm rounded-circle" src="/assets/dashboard/images/img-avatar.png" loading="lazy">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="d-block mb-0">
                                                ` + response.data.pe_fromname + `
                                            </h4>
                                            <p class="text-muted my-0">
                                                ` + response.data.pe_fromaddress + `
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ms-auto d-md-flex flex-md-column align-items-md-end">
                                        <small class="text-muted">
                                            ` + formatDateTime(response.data.pe_date) + `
                                        </small>
                                        <div class="">
                                            <i class="demo-psi-paperclip fs-5"></i>
                                            <a href="#_dm-attachment" class="fw-semibold btn-link">
                                                ` + response.data.attachments.length + ` lampiran file
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-1 mb-3">
                                    `;
                            
                        if ("{{ Auth::user()->can('Add Complaint') }}" && response.data.is_generate_report == 0) {
                            html += `
                                    <button type="button" class="btn btn-primary fw-bold" onclick="showOffcanvas(` + response.data.pe_msgno + `)">
                                        <i class="ri-edit-box-line align-middle fs-5 me-1"></i>
                                        Tambah sebagai Pengaduan
                                    </button>
                                    `;
                        }

                        if (response.data.is_generate_report == 1) {
                            html += `
                                    <span class="badge bg-info">
                                        Sudah Menjadi Laporan
                                    </span>
                            `;
                        }

                        html += `
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-outline-light fw-bold" onclick="loadList()">
                                            <i class="ri-arrow-left-s-line align-middle me-1"></i>
                                            Kembali
                                        </button>
                                    </div>
                                </div>
                                <div class="lh-lg py-4 border-top border-bottom">
                                    ` + response.data.pe_messagebody + `
                                </div>
                                        `;
                        
                        if(response.data.attachments.length > 0) {
                            html += `
                                <div id="_dm-attachment" class="mt-3">
                                    <span class="h6">
                                        <i class="demo-psi-paperclip me-2"></i>
                                        Lampiran 
                                        <span>(` + response.data.attachments.length + ` file) - </span>
                                    </span>
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                            `;

                            response.data.attachments.forEach(attachment => {
                                html += `
                                        <figure class="figure w-160px position-relative">
                                            <div class="figure-img ratio ratio-16x9">
                                                <i class="ri-file-zip-line fs-1 d-flex justify-content-center align-items-center bg-light rounded"></i>
                                            </div>
                                            <figcaption class="figure-caption">
                                                <a href="/storage/email/` + attachment + `" class="h6 stretched-link btn-link" target=_blank>
                                                    ` + attachment + `
                                                </a>
                                            </figcaption>
                                        </figure>
                                `;
                            });
                        }              

                        html += `
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        $('#mail-detail').append(html);
                    }
                }
             });
        }
        
        $(document).on('click', ".nextpage", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            loadList(url);
        });

        $(document).on('click', ".prevpage", function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            loadList(url);
        });
    </script>
@endsection