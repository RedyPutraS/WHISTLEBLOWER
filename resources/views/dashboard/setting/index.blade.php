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
                        Pengaturan
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Pengaturan
            </h1>
            <p class="lead">
                Atur konfigurasi yang dibutuhkan di dalam aplikasi
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                @foreach ($settings as $setting)
                    <div class="col-md-12 my-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="fw-bold mb-4">
                                    {{ $setting->pgtr_label }}
                                </h4>
                                <form action="{{ route('setting.update') }}" method="post">
                                    @foreach ($setting->config as $config)
                                        @csrf
                                        @method('put')
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-2">
                                                <label class="form-label">
                                                    {{ $config->pgtr_nama }}
                                                    <span class="text-danger font-weight-bold">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="hidden" name="pgtr_id[]" value="{{ $config->pgtr_id }}">
                                                @if ($config->pgtr_input_type == 'tags')
                                                    <input type="text" name="pgtr_nilai" class="form-control tagin" value="{{ $config->pgtr_nilai }}">
                                                @else
                                                    <input type="{{ $config->pgtr_input_type }}" name="pgtr_nilai[]" class="form-control" value="{{ $config->pgtr_nilai }}">
                                                @endif
                                                @if ($config->pgtr_note)
                                                    <p class="my-1">
                                                        Note: {{ $config->pgtr_note }}
                                                    </p>
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
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/tags.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/dashboard/js/tags.min.js') }}"></script>
@endsection