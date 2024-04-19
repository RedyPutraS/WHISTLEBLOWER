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
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-8 my-1">
                                    <h4 class="fw-bold mb-0">
                                        Ubah Role
                                    </h4>
                                </div>
                                <div class="col-xl-4 text-lg-right my-1">
                                    <a href="{{ route('role.index') }}" class="btn btn-primary btn-lg">
                                        <i class="ri-arrow-left-circle-line me-1 align-middle fs-4"></i>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('role.update', $role->r_id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label class="form-label">
                                        Nama Role
                                        <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="text" name="r_nama" id="r_nama" class="form-control" value="{{ $role->r_nama }}" required>
                                    @error('r_nama')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-2">
                                        Manajemen Akses Role
                                    </label>
                                     <div class="table-responsive">
                                        <table class="table" id="table" style="width: 100%;">
                                            <thead>
                                                <th></th>
                                                @foreach ($privilege_lists as $index => $privilege_list)
                                                    <th class="text-center">{{ $privilege_list->p_nama }}</th>
                                                @endforeach
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach ($privilegegroups as $index => $privilegegroup)
                                                    <tr>
                                                        <th class="align-middle">{{ $privilegegroup->pg_nama }}</th>
                                                        @foreach ($privilege_lists as $privilege_list)
                                                            <td width="250" class="text-center">
                                                            @foreach ($privilegegroup->privilege as $privilege)
                                                                @if ($privilege->p_nama == $privilege_list->p_nama)
                                                                    <label class="custom-control custom-checkbox align-middle">
                                                                        <input type="checkbox" name="p_ids[]" class="custom-control-input" value="{{ $privilege->p_id }}" @if(in_array($privilege->p_id, $role->role_privilege()->pluck('p_id')->toArray())) checked @endif>
                                                                        <span class="custom-control-label"></span>
                                                                    </label>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                            </td>
                                                        @endforeach
                                                        <th class="align-middle">{{ $privilegegroup->pg_nama }}</th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-primary text-white">
                                                <th></th>
                                                @foreach ($privilege_lists as $index => $privilege_list)
                                                    <th class="text-center">{{ $privilege_list->p_nama }}</th>
                                                @endforeach
                                                <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    @error('p_ids')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-5 text-end">
                                    <a href="{{ route('role.index') }}" class="btn btn-lg btn-dark me-2">
                                        <i class="bx bx-revision align-middle fs-4 me-1"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-lg btn-primary fw-bold">
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