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
                        Tanya Jawab
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Tanya Jawab
            </h1>
            <p class="lead">
                Tanya jawab terkait pengaduan
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-2">
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
                                <div class="col-xl-12 my-1">
                                    <h4 class="fw-bold mb-0">
                                        Pertanyaan
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dataTable dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:30px;">No.</th>
                                            <th>No. Pengaduan</th>
                                            <th>Penanya</th>
                                            <th>Waktu</th>
                                            <th style="width:100px;">Status</th>
                                            <th style="width:50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($discussions as $index => $discussion)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $index+1 }}
                                                </td>
                                                <td>
                                                    {{ $discussion->d_noreg }}
                                                </td>
                                                <td>
                                                    {{ $discussion->d_nama }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($discussion->d_waktu)->translatedFormat('d F Y H:i') }}
                                                </td>
                                                <td>
                                                    @if ($discussion->d_status == "Belum dijawab")
                                                        <span class="badge bg-danger">
                                                            {{ $discussion->d_status }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            {{ $discussion->d_status }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center column_action">
                                                    <div class="btn-group" role="group">
                                                        @if (Auth::user()->can('Edit Discussion'))
                                                            <button type="button" onclick="replyModal('{{ Crypt::encrypt($discussion->d_id) }}')" class="btn btn-sm btn-icon btn-bg-light btn-icon-success" title="Balas Pertanyaan">
                                                                <i class="ri-file-edit-fill"></i>
                                                            </button>
                                                        @endif
                                                    </div>
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

    {{-- Modal Reply --}}
    <div id="reply-modal" class="modal fade" tabindex="-1" aria-labelledby="reply-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reply-modal-label">
                        Pertanyaan Masuk | No. Pengaduan
                        <span id="noreg">WRK6JB</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('discussion.reply', 1) }}" method="post" id="reply-modal-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">
                                Jawaban
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="rd_pesan" id="rd_pesan" rows="10" class="form-control ckeditor"></textarea>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn py-2 btn-primary fw-bold">
                                <i class="bx bx-reply align-middle fs-4 me-1"></i>
                                Balas
                            </button>
                        </div>
                    </form>
                    <div class="mt-4" id="chat-card">
                        <div class="card my-4 shadow">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="col-md-1 d-none d-lg-block">
                                        <i class="ri-user-3-fill" style="font-size: 25px;"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h5 class="mb-0">
                                                    tim_investigator
                                                </h5>
                                            </div>
                                            <div class="col-md-3 mb-4 text-lg-right">
                                                31-12-2022 17:59
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                Ini adalah preview diskusi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatables.min.css') }}">
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
        var datatable = new Datatable({
            title: "Pertanyaan",
        });
    </script>
    <script>
        $('#reply-modal-form').on('submit',function (e) { 
            e.preventDefault();
            var url = $(this).attr('action');
            var rd_pesan = $('#rd_pesan').val();
            $('#loadMe').modal('show');

            setTimeout(function() {
                $("#loadMe").modal("hide");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token:"{{csrf_token()}}",
                        rd_pesan
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.success){
                            swal({
                                icon: "success",
                                title: 'Sukses',
                                text: response.message,
                                button: false,
                                timer: 2000,
                            });
                            $('#rd_pesan').val('');
                            $('#chat-card').empty();
                            getdiscussion(response.data.id);
                        }
                        else{
                            swal({
                                icon: "error",
                                title: 'Gagal Dikirim',
                                text: response.message,
                                button: false,
                                timer: 2000,
                            });
                        }
                    }
                }).then(function(){
                    setTimeout(function() { 
                        location.reload()
                     },1200);
                });
            }, 3500);

         });

        function replyModal(id) {
            $('#chat-card').empty();
            getdiscussion(id);
            $("#reply-modal").modal('show'); // Show up modal
        }

        function getdiscussion(id) { 
            var url = "{{route('discussion.getdiscussion',':id')}}";
            url = url.replace(':id',id);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token:"{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {
                    var urlreply = "{{ route('discussion.reply', ':id') }}";
                    urlreply = urlreply.replace(':id',response.data.id);
                    $('#noreg').html(response.data.discussion[0].rd_noreg);
                    response.data.discussion.forEach(chat => {
                        showdiscussion(chat.created_by,chat.created_at,chat.rd_pesan);
                    });
                    $('#reply-modal-form').attr('action',urlreply);
                }
            });
         }

        function showdiscussion(created_by,created_at,message) { 
            $('#chat-card').append(`
                <div class="card my-4 shadow">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="col-md-1 d-none d-lg-block">
                                <i class="ri-user-3-fill" style="font-size: 25px;"></i>
                            </div>
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h5 class="mb-0">
                                            `+created_by+`
                                        </h5>
                                    </div>
                                    <div class="col-md-3 mb-4 text-lg-right">
                                        `+formatDateTimeShort(created_at)+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        `+message+`
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        
    </script>
@endsection