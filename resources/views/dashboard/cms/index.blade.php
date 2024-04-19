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
                        Content Management System
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Content Management System
            </h1>
            <p class="lead">
                CMS untuk manajemen konten aplikasi
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">

             <div class="row">
                @foreach ($cmses as $cms)
                    <div class="col-md-12 my-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="fw-bold mb-4">
                                    {{ $cms->cms_halaman }}
                                </h4>
                                <form action="{{ route('cms.update') }}" method="post" enctype="multipart/form-data">
                                    @foreach ($cms->content as $key => $content)
                                        @csrf
                                        @method('put')
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-2">
                                                <label class="form-label">
                                                    {{ $content->cms_label }}
                                                    <span class="text-danger font-weight-bold">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="hidden" name="cms_id[{{ $key }}]" value="{{ $content->cms_id }}">
                                                @if ($content->cms_input_type == 'textarea')
                                                    <textarea name="cms_konten[{{ $key }}]" id="cms-{{ $content->cms_id }}" rows="10" class="form-control ckeditor">{{ $content->cms_konten }}</textarea>
                                                @elseif ($content->cms_input_type == 'file')
                                                    <input type="{{ $content->cms_input_type }}" name="cms_konten[{{ $key }}]" class="form-control" accept=".jpg,.jpeg,.png">
                                                @else
                                                    <input type="{{ $content->cms_input_type }}" name="cms_konten[{{ $key }}]" class="form-control" value="{{ $content->cms_konten }}">
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            <i class="bx bxs-save align-middle fs-4 me-1"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .ck-content {
            height: 340px!important;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('.ckeditor');
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.removeFormatAttributes = '';
    </script>
@endsection