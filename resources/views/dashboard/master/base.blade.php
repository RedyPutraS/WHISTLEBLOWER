<!DOCTYPE html>
<html lang="id">

<head>
    <title>Whistleblower &#8211; MNK</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Aplikasi Whistleblower PT. Multi Nitrotama Kimia" name="description" />
    <meta content="PT. ALFAHUMA REKAYASA TEKNOLOGI" name="author" />

    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}"> 
    
    <link rel="shortcut icon" href="{{ asset('assets/dashboard/images/favicon.png') }}">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Work+Sans%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%7CPoppins%3A600%2C400%2C500%7CRoboto+Condensed%3A400%7CRoboto%3A400%7CArimo%3A400%7CJosefin+Sans%3A600" media="all" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.mobile.css') }}">
    @yield('css')
</head>

<body class="jumping">
    <div id="root" class="root mn--min mn--sticky hd--sticky hd--expanded">
        <section id="content" class="content">
            @yield('content')
            <footer class="mt-auto">
                @include('dashboard.master.components.footer')
            </footer>
        </section>

        <header class="header">
            <div class="header__inner">
                <div class="header__brand">
                    <div class="brand-wrap">
                        <a href="{{ route('dashboard') }}" class="brand-img stretched-link">
                            <img src="{{ asset('assets/dashboard/images/logomnkwhite.png') }}" alt="Logo MNK" class="logo" width="40" height="40">
                        </a>
                        <div class="brand-title">
                            Whistleblower
                        </div>
                    </div>
                </div>
                <div class="header__content">
                    <div class="header__content-start">
                        <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm" aria-label="Nav Toggler">
                            <i class="bx bx-menu"></i>
                        </button>
                    </div>
                    <div class="header__content-end">
                        <div class="dropdown">
                            <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-label="Notification dropdown" aria-expanded="false">
                                <span class="d-block position-relative">
                                    <i class="bx bx-bell"></i>
                                    <div class="notification-icon"></div>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end w-md-300px">
                                <div class="border-bottom px-3 py-2 mb-3">
                                    <h5>Notifikasi Hari Ini</h5>
                                </div>
                                <div class="list-group list-group-borderless" id="notification">
                                    <div class="list-group-item list-group-item-action d-flex align-items-start mb-3 notification-content">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="me-3 notification-label">
                        </div>
                        <div class="dropdown">
                            <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-label="User dropdown" aria-expanded="false">
                                <i class="ri-xl ri-user-2-fill"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end w-md-450px">
                                <div class="d-flex align-items-center border-bottom px-3 py-2">
                                    <div class="flex-shrink-0">
                                        <img class="img-sm rounded-circle" src="{{ asset('assets/dashboard/images/img-avatar.png') }}" alt="Avatar" loading="lazy">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-0">
                                            {{ auth()->user()->u_nama }}
                                        </h5>
                                        <span>
                                            {{ auth()->user()->role->r_nama }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="list-group list-group-borderless">
                                            <div class="list-group-item text-center">
                                                <p class="h2 display-1 text-blue" style="font-size: 4rem;">
                                                    {{ $data['countreport'] }}
                                                </p>
                                                <p class="h6 mb-0">
                                                    <i class="bx bxs-file align-middle text-blue fs-3 me-2"></i>
                                                    Laporan hari ini
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="list-group list-group-borderless h-100 py-3">
                                            <a href="{{ route('user.profile',Crypt::encrypt(auth()->user()->u_id))}}" class="list-group-item list-group-item-action">
                                                <i class="ri-user-fill align-middle fs-5 me-2"></i>
                                                Profile
                                            </a>
                                            <a href="{{ route('help') }}" class="list-group-item list-group-item-action">
                                                <i class="ri-information-line align-middle fs-5 me-2"></i>
                                                Bantuan
                                            </a>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action">
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="u_id" value="{{ Crypt::encrypt(auth()->user()->u_id) }}">
                                                </form>
                                                <i class="mdi mdi-logout align-middle fs-5 me-2"></i>
                                                Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <nav id="mainnav-container" class="mainnav">
            <div class="mainnav__inner">
                <div class="mainnav__top-content scrollable-content pb-5">
                    @include('dashboard.master.components.sidebar')
                </div>
            </div>
        </aside>

    </div>

    <div class="scroll-container">
        <a href="#root" class="scroll-page rounded-circle ratio ratio-1x1" aria-label="Scroll button"></a>
    </div>

    <script src="{{ asset('assets/dashboard/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/main.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        setTimeout(function () {
            $(".alert-dismissible").alert('close');
        }, 3000);

        $.ajax({
            type: "POST",
            url: "{{ route('getnotification') }}",
            data: {
                _token:"{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                if (response.data.total > 0) {
                    var html = `
                        <div class="flex-shrink-0 me-3">
                            <i class="bx bxs-file text-blue-200 fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ">
                            <a href="{{ route('complaint.index') }}" class="h6 d-block mb-0 stretched-link text-decoration-none">
                                Ada ` + response.data.total + ` laporan perlu ditindaklanjuti
                            </a>
                            <small class="text-muted">
                                ` + response.data.time + `
                            </small>
                        </div>
                    `;
                    $('.notification-content').html(html);
                    
                    var htmlicon = `
                        <span class="badge badge-super rounded bg-danger p-1"></span>
                    `;
                    $('.notification-icon').html(htmlicon);
                    
                    var htmllabel = `
                        Anda memiliki ` + response.data.total + ` notifikasi laporan
                    `;
                    $('.notification-label').html(htmllabel);
                } 
                else {
                    var html = `
                        <h6>Tidak ada notifikasi.</h6>
                    `;
                    $('.notification-content').html(html);
                    $('.notification-icon').html('');
                    var htmllabel = `
                        Belum ada notifikasi hari ini
                    `;
                    $('.notification-label').html(htmllabel);
                }
            }
        });
    </script>
    @include('sweetalert::alert')
    @yield('js')
</body>
</html>