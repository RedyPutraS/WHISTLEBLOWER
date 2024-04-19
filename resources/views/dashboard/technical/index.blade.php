@extends('dashboard.master.base')

@section('content')
    <div class="content__header content__boxed overlapping mb-4">
        <div class="content__wrap text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <i class="ri-home-4-line"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Area Teknisi
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Area Teknisi
            </h1>
            <p class="lead">
                Halaman ini hanya dapat diakses oleh teknisi
            </p>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 my-2">
                            <div class="mb-5">
                                <h3 class="fw-bold mb-4">
                                    BACK UP DATABASE
                                </h3>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-primary fw-bold">
                                        <i class="ri-download-cloud-line fs-5 align-middle me-1"></i>
                                        Backup
                                    </button>
                                </div>
                                <p class="mb-1">
                                    Klik tombol "Backup" untuk mengunduh file database dari aplikasi Whistleblower - MNK ini!
                                </p>
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <img class="img-fluid" src="{{ asset('assets/dashboard/images/img-help.jpg') }}" alt="Bantuan">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection