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
                        Data Master User
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Data Master User
            </h1>
            <p class="lead">
                Manajemen data master user aplikasi
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="mb-3 text-lg-right">
                @if (Auth::user()->can('Add User'))
                    <button type="button" onclick="addModal()" class="btn btn-secondary btn-lg fw-bold">
                        <i class="bx bx-plus-circle align-middle fs-4 me-1"></i>
                        Tambah
                    </button>
                @endif
            </div>
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
            <div class="row justify-content-center">
                @foreach ($users as $user)
                    <div class="col-md-3 my-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end gap-1">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon btn-hover btn-light fw-bold shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if (Auth::user()->can('Edit User'))
                                                <li>
                                                    <button type="button" onclick="editModal('{{Crypt::encrypt($user->u_id)}}')" class="dropdown-item text-info fw-bold">
                                                        <i class="ri-pencil-fill align-middle fs-5 me-1"></i>
                                                        Ubah
                                                    </button>
                                                </li>
                                            @endif
                                            @if (Auth::user()->can('Delete User'))
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger fw-bold" onclick="deleteModal('{{ Crypt::encrypt($user->u_id) }}');">
                                                        <i class="ri-delete-bin-2-fill align-middle fs-5 me-1"></i>
                                                        Hapus
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center position-relative">
                                    <div class="pb-3">
                                        @if ($user->role->r_nama == 'Administrator')
                                            <img class="img-lg rounded-circle" src="{{ asset('assets/dashboard/images/img-avatar-administrator.png') }}" alt="{{ $user->u_nama }}" loading="lazy">
                                        @elseif ($user->role->r_nama == 'Investigator')
                                            <img class="img-lg rounded-circle" src="{{ asset('assets/dashboard/images/img-avatar-investigator.png') }}" alt="{{ $user->u_nama }}" loading="lazy">
                                        @elseif ($user->role->r_nama == 'Technical')
                                            <img class="img-lg rounded-circle" src="{{ asset('assets/dashboard/images/img-avatar-technical.png') }}" alt="{{ $user->u_nama }}" loading="lazy">
                                        @else
                                            <img class="img-lg rounded-circle" src="{{ asset('assets/dashboard/images/img-avatar.png') }}" alt="{{ $user->u_nama }}" loading="lazy">
                                        @endif
                                    </div>
                                    <p class="h5 fw-bold">
                                        {{ $user->u_nama }}
                                    </p>
                                    <p class="m-0">
                                        {{ $user->role->r_nama }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal Form Data --}}
    <div id="form-modal" class="modal fade" tabindex="-1" aria-labelledby="form-modal-label" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.store') }}" method="post" id="form-modal-form">
                    @csrf
                    <input type="hidden" name="_method" id="_method" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-modal-label">
                            Tambah User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">
                                Nama
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="u_nama" id="u_nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Username
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="u_username" id="u_username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Email
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="u_email" id="u_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Password
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="u_password" id="u_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Role
                                <span class="text-danger">*</span>
                            </label>
                            <select name="r_id" id="r_id" class="form-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->r_id }}">{{ $role->r_nama }}</option>
                                @endforeach
                            </select>
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

@section('js')
    <script>
        function addModal() {
            $('input').val();
            $('#_token').val('{{csrf_token()}}');
            $("#form-modal").modal('show'); // Show up modal
            $("#form-modal-label").text('Tambah User'); // Change modal title
        }

        function editModal(id) {
            var urlget = "{{route('user.getdatauser',':id')}}";
            urlget = urlget.replace(':id',id);
            var urlupdate = "{{route('user.update',':id')}}";
            urlupdate = urlupdate.replace(':id',id);
            $('#_token').val('{{csrf_token()}}');
            $('#_method').val('PUT');
            $.ajax({
                type: "POST",
                url: urlget,
                data: {
                    _token:"{{csrf_token()}}",
                },
                dataType: "json",
                success: function (response) {
                    if(response.success){
                        $('#u_nama').val(response.data.u_nama);
                        $('#u_username').val(response.data.u_username);
                        $('#u_username').prop('readonly',true);
                        $('#u_email').val(response.data.u_email);
                        $('#u_email').prop('readonly',true);
                        $('#u_password').val();
                        $('#r_id').val(response.data.r_id);
                        $('#form-modal-form').attr('action',urlupdate);
                        $("#form-modal").modal('show'); // Show up modal
                        $("#form-modal-label").text('Ubah User'); // Change modal title
                    }else{
                        swal({
                            icon: "warning",
                            title: 'Data Not Found',
                            text: 'Data tidak ditemukan!',
                        });
                    }
                }
            });
        }

        function deleteModal(id) {
            var urldelete = "{{ route('user.destroy', ':param') }}";
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
                            _token : "{{csrf_token()}}",
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