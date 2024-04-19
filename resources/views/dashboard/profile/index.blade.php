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
                        Profil
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Profil
            </h1>
            <p class="lead">
                Profil pengguna
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
                                        Data Akun
                                    </h4>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('user.profileupdate',Crypt::encrypt($user->u_id))}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>
                                        Nama
                                        <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="text" name="u_nama" id="u_nama" class="form-control" value="{{ $user->u_nama }}" readonly>
                                    @error('u_nama')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Username
                                        <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="text" name="u_username" id="u_username" class="form-control" value="{{ $user->u_username }}" readonly required>
                                    @error('u_username')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Email
                                        <span class="text-danger font-weight-bold">*</span>
                                    </label>
                                    <input type="email" name="u_email" id="u_email" class="form-control" value="{{ $user->u_email }}" readonly required>
                                    @error('u_email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="changepassword_container">
                                    <button type="button" class="btn btn-primary changepassword">
                                        <i class="ri-lock-2-fill align-middle me-1"></i>
                                        Ubah Password?
                                        <span class="ml-1 font-weight-bold changepassword_text changepassword_text_yes d-none">Ya</span>
                                        <span class="ml-1 font-weight-bold changepassword_text changepassword_text_no">Tidak</span>
                                    </button>
                                    <div class="changepasswordform mt-2">
                                        @if(Session::has('oldpassword') || Session::has('newpassword'))
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label>
                                                        Password Lama
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    @if (Session::has('oldpassword'))
                                                        <div class="text-danger">
                                                            {{ Session::get('oldpassword') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="password" name="oldpassword" id="oldpassword" class="form-control @if(Session::has('oldpassword')) is-invalid @endif">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label>
                                                        Password Baru
                                                        <span class="text-danger font-weight-bold">*</span>
                                                    </label>
                                                    @if (Session::has('newpassword'))
                                                        <div class="text-danger">
                                                            {{ Session::get('newpassword') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="password" name="newpassword" id="newpassword" class="form-control @if(Session::has('newpassword')) is-invalid @endif">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-5 text-right">
                                    <a href="{{ route('role.index') }}" class="btn btn-dark me-2">
                                        <i class="ri-save-2-fill align-bottom me-1"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-delete-bin-fill align-bottom me-1"></i>
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
        $('.changepassword_container').on('click', '.changepassword', function() {
            $('.changepassword_text_yes').toggleClass('d-none');
            $('.changepassword_text_no').toggleClass('d-none');
            var html = `
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>
                            Password Lama
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        @error('oldpassword')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-10">
                        <input type="password" name="oldpassword" id="oldpassword" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>
                            Password Baru
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                    </div>
                    <div class="col-md-10">
                        <input type="password" name="newpassword" id="newpassword" class="form-control">
                    </div>
                </div>
            `;
            if ($('.changepasswordform').html() == html) {
                $('.changepasswordform').html("");
            } 
            else {
                $('.changepasswordform').html(html);
            }
        });
    </script>
@endsection
