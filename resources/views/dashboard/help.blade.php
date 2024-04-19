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
                        Bantuan
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mt-4">
                Halaman Bantuan
            </h1>
            <p class="lead">
                Kontak PT. Multi Nitrotama Kimia (MNK) untuk bantuan teknis aplikasi
            </p>
            <div class="d-flex flex-wrap gap-2 justify-content-center mt-3 mb-4">
                <a href="tel:02129035022" class="btn btn-secondary fw-bold">
                    <i class="ri-phone-fill align-middle me-1"></i>
                    Telpon Kami
                </a>
                <a href="mailto:company.info@mnk.co.id" class="btn btn-light fw-bold">
                    <i class="ri-mail-send-fill align-middle me-1"></i>
                    Email Kami
                </a>
            </div>
        </div>
    </div>
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-7 my-2">
                            <div class="mb-5">
                                <h3 class="fw-bold mb-4">
                                    HEAD OFFICE
                                </h3>
                                <p class="mb-1">
                                    Equity Tower 41th Floor Suite E
                                </p>
                                <p class="mb-1">
                                    Sudirman Central Business Disctrict (SCBD)
                                </p>
                                <p class="mb-1">
                                    Jl. Jend. Sudirman Kav. 52-53 Lot 9
                                </p>
                                <p class="mb-1">
                                    Jakarta 12190
                                </p>
                                <p class="mb-1">
                                    Telp : (+62-21) 2903 5022 (Hunting),
                                </p>
                                <p class="mb-1">
                                    Fax : (+62-21) 2903 5021
                                </p>
                            </div>
                            <div class="mb-5">
                                <h3 class="fw-bold mb-4">
                                    EMAIL CONTACTS
                                </h3>
                                <p class="mb-1">
                                    Company Information – company.info@mnk.co.id
                                </p>
                                <p class="mb-1">
                                    Safety, Health & Environment Enquiries – company.ehs@mnk.co.id
                                </p>
                                <p class="mb-1">
                                    MNK Careers Enquiries (Indonesia only) – career@mnk.co.id
                                </p>
                                <p class="mb-1">
                                    MNK Support; for product knowledge only – support@mnk.co.id
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