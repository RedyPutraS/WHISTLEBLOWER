<!doctype html>
<html lang="id">

<head>
    <title>Whistleblower - MNK</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Aplikasi Whistleblower PT. Multi Nitrotama Kimia" name="description" />
    <meta content="PT. ALFAHUMA REKAYASA TEKNOLOGI" name="author" />
    
    <link rel="shortcut icon" href="{{ asset('assets/dashboard/images/favicon.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Work+Sans%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%7CPoppins%3A600%2C400%2C500%7CRoboto+Condensed%3A400%7CRoboto%3A400%7CArimo%3A400%7CJosefin+Sans%3A600" media="all" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}">
</head>

<body style="background: #f0f5fc;">
  <div style="padding:0px; overflow: hidden; width:100%">
    <div class="container-fluid">      
      <div class="row">
        <div style="background: url('{{ asset('assets/auth/images/bg-login.png') }}');background-repeat: no-repeat;height: 100vh;background-position: right;" class="col-7 logo-left">
        </div>
        <div class="col-lg-5" style="text-align:left; background-color: #f0f5fc; padding: 20px;">
            <div class="row m-0 section-content-utama">
              <div class="col-md-12 section-content-kedua">
                <div class="mb-3">
                  <img src="{{ asset('assets/dashboard/images/logomnk.png') }}" alt="Logo MNK">
                </div>
                <form action="{{ route('login') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-12 mb-3 pl-0" style="border-bottom: solid 3px #002c5b;">
                      <h3 class="fw-bold" style="margin-top: 10px;">
                        Whistleblower - PT. Multi Nitrotama Kimia (MNK)
                      </h3>
                    </div>
                  </div>
                  @if($errors->any())
                    <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label" data-aos="fade-right">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif
                  <div class="row pt-3" >
                    <div class="col-sm-12 pl-0">
                      <div class="form-group my-4">
                          <label>Username/email</label>
                          <input id="username" name="username" type="text" class="form-control" placeholder="Masukkan username">
                      </div>
                      <div class="form-group my-4">
                          <label>Password</label>
                          <div>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password">
                          </div>
                      </div>
                    </div>
                    <div class="col-12 pl-0">
                      <div class="text-end">
                        <button type="submit" class="btn btn-block text-white px-5" style="border-radius: 24px; background: #002c5b!important;">
                          Login
                        </button>
                      </div>
                      <hr>
                      <div class="p-0 mt-1 text-end">
                        <b class="m-t-20">PT. Multi Nitrotama Kimia (MNK) 2022</b>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/dashboard/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/auth/js/animsition.js') }}"></script>

</body>
</html>
