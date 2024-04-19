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
                        Data Master Status
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Data Master Status
            </h1>
            <p class="lead">
                Manajemen data master status untuk pengaduan
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
                                <div class="col-xl-8 my-1">
                                    <h4 class="fw-bold mb-0">
                                        Data Status
                                    </h4>
                                </div>
                                <div class="col-xl-4 text-lg-right my-1">
                                    @if (Auth::user()->can('Add Status'))
                                        <button type="button" onclick="addModal()" class="btn btn-primary btn-lg fw-bold">
                                            <i class="bx bx-plus-circle align-middle fs-4 me-1"></i>
                                            Tambah
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dataTable dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:30px;">No.</th>
                                            <th>Status</th>
                                            <th>Urutan dalam Tahapan</th>
                                            <th>Deskripsi</th>
                                            <th>Label</th>
                                            <th>Keterangan</th>
                                            <th style="width:50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statuses as $index => $status)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $index+1 }}
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: {{ $status->s_warna_background }}; color: {{ $status->s_warna_teks }};">
                                                        {{ $status->s_nama }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{ $status->s_urutan }}
                                                </td>
                                                <td>
                                                    {{ $status->s_deskripsi }}
                                                </td>
                                                <td>
                                                    {{ $status->s_label }}
                                                </td>
                                                <td>
                                                    {{ $status->s_keterangan }}
                                                </td>
                                                <td class="text-center column_action">
                                                    <div class="btn-group" status="group">
                                                        @if (Auth::user()->can('Edit Status'))
                                                            <button type="button" onclick="editModal('{{ Crypt::encrypt($status->s_id) }}')" class="btn btn-sm btn-icon btn-bg-light btn-icon-success fw-bold" title="Ubah">
                                                                <i class="ri-pencil-fill"></i>
                                                            </button>
                                                        @endif
                                                        @if (Auth::user()->can('Delete Status'))
                                                            <button type="button" onclick="deleteModal('{{ Crypt::encrypt($status->s_id) }}')" class="btn btn-sm btn-icon btn-bg-light btn-icon-success fw-bold" title="Hapus">
                                                                <i class="ri-delete-bin-2-fill"></i>
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

    {{-- Modal Form Data --}}
    <div id="form-modal" class="modal fade" tabindex="-1" aria-labelledby="form-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('status.store') }}" method="post" id="form-modal-form">
                    @csrf
                    <input type="hidden" name="_method" id="_method" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-modal-label">
                            Tambah Status
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">
                                Nama Status
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="s_nama" id="s_nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Urutan dalam Tahapan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="s_urutan" id="s_urutan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Label
                            </label>
                            <select name="s_label" id="s_label" class="form-select">
                                <option value="Global">Global</option>
                                <option value="Penyelidikan">Penyelidikan</option>
                                <option value="Penyidikan">Penyidikan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Deskripsi
                            </label>
                            <textarea name="s_deskripsi" id="s_deskripsi" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Keterangan
                            </label>
                            <textarea name="s_keterangan" id="s_keterangan" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Warna Background untuk Status
                            </label>
                            <div>
                                <input type="color" value="#25476a" id="backgroundcolorpicker" oninput="setColor('backgroundcolorpicker', 's_warna_background')">
                                <input type="text" name="s_warna_background" id="s_warna_background" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Warna Teks untuk Status
                            </label>
                            <div>
                                <input type="color" value="#25476a" id="textcolorpicker" oninput="setColor('textcolorpicker', 's_warna_teks')">
                                <input type="text" name="s_warna_teks" id="s_warna_teks" class="form-control">
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
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatables.min.css') }}">
    <style>
        input[type="color"] {
            background-color: #fff;
            width: 200px;
            height: 30px;
            cursor: pointer;
            border: 2px solid #000;
            border-radius: 3px;
            margin-bottom: 5px;
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
    <script src="{{ asset('helpers/js/colorpickerhelper.js') }}"></script>
    <script>
        var datatable = new Datatable({
            title: "Data Master Status",
        });
    </script>
    <script>
        function addModal() {
            var urladd = "{{ route('status.store') }}";
            $('#form-modal-form').attr('action', urladd);
            
            $('input').val();
            $('#_token').val('{{ csrf_token() }}');
            $("#form-modal").modal('show'); // Show up modal
            $("#form-modal-label").text('Tambah Status'); // Change modal title
        }

        function editModal(id) {
            var urlget = "{{route('status.getdata',':id')}}";
            urlget = urlget.replace(':id',id);

            var urlupdate = "{{route('status.update',':id')}}";
            urlupdate = urlupdate.replace(':id',id);

            $('#_token').val('{{ csrf_token() }}');
            $('#_method').val('PUT');
            $.ajax({
                type: "POST",
                url: urlget,
                data: {
                    _token:"{{ csrf_token() }}",
                },
                dataType: "json",
                success: function (response) {
                    if (response.success){
                        $('#s_nama').val(response.data.s_nama);
                        $('#s_label').val(response.data.s_label);
                        $('#s_urutan').val(response.data.s_urutan);
                        $('#s_deskripsi').val(response.data.s_deskripsi);
                        $('#s_keterangan').val(response.data.s_keterangan);
                        $('#s_warna_background').val(response.data.s_warna_background);
                        $('#backgroundcolorpicker').val(response.data.s_warna_background);
                        $('#s_warna_teks').val(response.data.s_warna_teks);
                        $('#textcolorpicker').val(response.data.s_warna_teks);

                        $('#form-modal-form').attr('action',urlupdate);
                        $("#form-modal").modal('show'); // Show up modal
                        $("#form-modal-label").text('Ubah Status'); // Change modal title
                    }
                    else{
                        swal({
                            icon: "warning",
                            title: 'Gagal',
                            text: response.message,
                        });
                    }
                }
            });
        }

        function deleteModal(id) {
            var urldelete = "{{ route('status.destroy', ':param') }}";
            urldelete = urldelete.replace(':param', id);
            swal({
                icon: 'warning',
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah anda yakin ingin menghapus data ini?',
                buttons: ["Batal", "Hapus"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        data: {
                            _token : "{{ csrf_token() }}"
                        },
                        url: urldelete,
                        dataType: "json",
                        success: function (response) {
                            if(response.success){
                                swal({
                                    icon: "success",
                                    title: 'Sukses',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((value) => {
                                    location.reload(); 
                                });
                
                            }
                            else{
                                swal({
                                    icon: "error",
                                    title: 'Gagal',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection