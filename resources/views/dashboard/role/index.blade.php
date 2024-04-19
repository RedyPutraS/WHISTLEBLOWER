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
                    <li class="breadcrumb-item">
                        Manajemen Akses
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Master Role
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Data Master Role
            </h1>
            <p class="lead">
                Manajemen data master role untuk user aplikasi
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
                                        Data Role
                                    </h4>
                                </div>
                                <div class="col-xl-4 text-lg-right my-1">
                                    @if (Auth::user()->can('Add Role'))
                                        <a href="{{ route('role.create') }}" class="btn btn-primary btn-lg fw-bold">
                                            <i class="bx bx-plus-circle align-middle fs-4 me-1"></i>
                                            Tambah
                                        </a>
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
                                            <th>Role</th>
                                            <th style="width:50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $index+1 }}
                                                </td>
                                                <td>
                                                    {{ $role->r_nama }}
                                                </td>
                                                <td class="text-center column_action">
                                                    <div class="btn-group" role="group">
                                                        @if (Auth::user()->can('Edit Role'))
                                                            <a href='{{ route('role.edit', $role->r_id) }}' class="btn btn-sm btn-icon btn-bg-light btn-icon-success fw-bold" title="Ubah">
                                                                <i class="ri-pencil-fill"></i>
                                                            </a>
                                                        @endif
                                                        @if (Auth::user()->can('Delete Role'))
                                                            <button type="button" onclick="deleteModal({{ $role->r_id }})" class="btn btn-sm btn-icon btn-bg-light btn-icon-success fw-bold" title="Hapus">
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
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatables.min.css') }}">
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
    <script>
        var datatable = new Datatable({
            title: "Role",
        });
    </script>
    <script>
        function deleteModal(id) {
            var urldelete = "{{ route('role.destroy', ':param') }}";
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
                            _token : "{{csrf_token()}}"
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
                
                            }else{
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