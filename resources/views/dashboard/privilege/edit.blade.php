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
                        Data Master Privilege
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Data Master Privilege
            </h1>
            <p class="lead">
                Manajemen data master privilege
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8 my-1">
                                    <h4 class="fw-bold mb-0">
                                        Ubah Privilege
                                    </h4>
                                </div>
                                <div class="col-xl-4 text-lg-right my-1">
                                    <a href="{{ route('privilege.index') }}" class="btn btn-primary btn-lg">
                                        <i class="ri-arrow-left-circle-line me-1 me-1 me-1 align-middle fs-4"></i>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('privilege.update', $privilegegroup->pg_id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label class="form-label">
                                        Nama Privilege
                                        <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="text" name="pg_nama" id="pg_nama" class="form-control" value="{{$privilegegroup->pg_nama }}" required>
                                    @error('pg_nama')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <input type="hidden" value="0" id="total_input">
                                <div class="d-flex pb-3">
                                    <button type="button" class="btn btn-info btn me-2 addPrivilege">
                                        <i class="bx bx-plus-circle align-middle fs-4 me-1"></i>
                                        Tambah Isi Privilege
                                    </button>
                                    <button type="button" class="btn btn-info defaultPrivilege">
                                        <i class="bx bx-list-plus align-middle fs-4 me-1"></i>
                                        Gunakan Isi Privilege Default
                                    </button>
                                </div>
                                @if ( count($privilegegroup->privilege) == 0)
                                <div class="form-group" id="privilege">
                                    <div class="privilege-content mt-2">
                                        <div class="row align-items-center">
                                            <div class="form-group col-md-11 mb-1">
                                                <label class="form-label">
                                                    Isi Privilege
                                                    <span class="text-danger font-weight-bold">*</span>
                                                </label>
                                                <input type="text" name="p_namas[]" class="form-control">
                                                <small>Contoh: Manage/View/Add/Edit/Delete</small>
                                            </div>
                                            <div class="form-group col-md-1 my-0">
                                                <button type="button" class="btn btn-danger d-none removePrivilege">
                                                    <i class="ri-delete-bin-2-fill align-middle fs-5 me-1"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('p_namas')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @else
                                    @foreach ($privilegegroup->privilege as $index => $privilege)
                                    <div class="form-group" id="privilege">
                                        <div class="privilege-content mt-2">
                                            <div class="row align-items-center">
                                                <div class="form-group col-md-11 mb-1">
                                                    <label class="form-label">
                                                        Isi Privilege
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    <input type="text" name="p_namas[]" class="form-control" value="{{$privilege->p_nama}}">
                                                    <small>Contoh: Manage/View/Add/Edit/Delete</small>
                                                </div>
                                                <div class="form-group col-md-1 my-0">
                                                    <button type="button" class="btn btn-danger @if($index == 0) d-none @endif removePrivilege">
                                                        <i class="ri-delete-bin-2-fill align-middle fs-5 me-1"></i>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('p_namas')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @endforeach
                                @endif
                                
                                <div class="mt-5 text-end">
                                    <a href="{{ route('privilege.index') }}" class="btn btn-lg btn-dark me-2">
                                        <i class="bx bx-revision align-middle fs-4 me-1"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        <i class="bx bxs-save align-middle fs-4 me-1"></i>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.addPrivilege').on('click', function () {
            $('.privilege-content:first').clone().find("input").val("").end().find('.removePrivilege').removeClass('d-none').end().insertAfter(".privilege-content:last");
        });

        $('.defaultPrivilege').on('click', function () {
            var privileges = ["Manage", "View", "Add", "Edit", "Delete"];
            privileges.forEach(privilege => {
                $('.privilege-content:first').clone().find("input").val(privilege).end().find('.removePrivilege').removeClass('d-none').end().insertAfter(".privilege-content:last");
            });
            $('.privilege-content:first').remove();
        });

        $(document).on('click', '.removePrivilege', function () {
           $(this).closest('.privilege-content').remove();
        });
    </script>
@endsection