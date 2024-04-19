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
                      Log Aktivitas
                  </li>
              </ol>
          </nav>
      </div>
    </div>
    <div class="content__boxed">
      <div class="content__wrap">
          <div class="row">
              <div class="col-md-12">
                  <div class="mb-2">
                  </div>
                  <div class="card">
                      <div class="card-header">
                          <h4 class="fw-bold mb-0">
                              Log Aktivitas
                          </h4>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dataTable dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:30px;">No</th>
                                        <th>Aktivitas</th>
                                        <th>User</th>
                                        <th style="width:100px;">Waktu</th>
                                    </tr>
                                </thead>
                            </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
    
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/datatables.min.css') }}">
    <style>
        .ck-content {
            height: 340px!important;
        }
    </style>
@endsection

@section('js')  
  <script src="{{ asset('assets/dashboard/js/datatables/jquery.datatables.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.colvis.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/datatables/datatables.buttons.jszip.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/moment.min.js') }}"></script>
  <script src="{{ asset('assets/dashboard/js/moment-with-locales.js') }}"></script>
  <script src="{{ asset('helpers/js/serversidedatatables.js') }}"></script>
  <script src="{{ asset('helpers/js/formathelper.js') }}"></script>
  <script>
    var url = "{{ route('log.datatable') }}";
    var datatable = new Datatable({
        title: "Inbox Email",
        url: url,
        csrf:  "{{ csrf_token() }}",
        columns: [
            {
                title: 'No.',
                data: 'l_id',
                className: 'column_number text-center',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                title: 'Aktivitas',
                data: 'l_nama_aktivitas',
                className: 'column_l_nama_aktivitas'
            },
            {
                title: 'User',
                data: 'l_nama_user',
                className: 'column_l_nama_user',
            },
            {
                title: 'Waktu',
                data: 'created_at',
                className: 'column_created_at',
                render: function(data, type, row, meta){
                    return formatDateTimeSecond(data);
                }
            },
        ],
        buttons: "default",
    });
</script>
  
@endsection