@extends('front.master.base')

@section('content')
    <article class="post-63 page type-page status-publish hentry">
        <div class="entry-content container">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a id="detailreport" class="nav-link" aria-current="page" >
                        Detail
                    </a>
                </li>
                <li class="nav-item active">
                    <a id="resultreport" class="nav-link">
                        Progress
                    </a>
                </li>
                <li class="nav-item">
                    <a id="askquestion" class="nav-link">
                        Tanya Tim
                    </a>
                </li>
            </ul>
            <div class="tab-content clearfix py-5">
                <div class="tab-pane active" id="1a">
                    <h4 class="vc_custom_heading">
                        @if ($cms['Judul'])
                            {!! $cms['Judul'] !!}
                        @else
                            Perkembangan Pengaduan
                        @endif
                    </h4>
                    @foreach ($historyreport as $history)    
                    <div class="my-4">
                        <div class="">
                            <span class="badge badge-flat" style="font-size: 15px;">
                                {{ \Carbon\Carbon::parse($history->fr_tanggal)->translatedFormat('d-m-Y') }}
                            </span>
                        </div>
                        <p>
                            {!! $history->fr_keterangan !!}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal fade" id="form-modal-token" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <form action="#" method="post" id="showbuktiform">
                            <div class="form-group">
                                <label>
                                    Masukkan Token
                                </label>
                                <input type="hidden" id="action" name="action" value="">
                                <input type="text" name="f_token" id="f_token" value="">
                            </div>
                            <div class="mt-4 pull-right d-flex">
                                <button type="button" class="close btn btn-danger px-4 mr-2" style="min-width:70px;font-size: 1.5rem!important;">
                                    Tutup
                                </button>
                                <button type="button" id="submit" class="cmt-vc_general cmt-vc_btn3 cmt-vc_btn3 cmt-vc_btn3-color-black" style="min-width:70px;">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

@section('js')
<script src="{{ asset('helpers/js/fronthelpers.js') }}"></script>
<script>
    var checksession =  checksession(token,checkurl,"{{$report->f_noreg}}");
    $('#detailreport').on('click',function (e) { 
        e.preventDefault();
        $('#action').val('detailreport');
        if(checksession.success){
            $('#f_token').val(checksession.data);
            urlref();
        }else{
            $('#form-modal-token').toggleClass('show');
        }
    });

    $('#resultreport').on('click',function (e) { 
        e.preventDefault();
        $('#action').val('resultreport');
        if(checksession.success){
            $('#f_token').val(checksession.data);
            urlref();
        }else{
            $('#form-modal-token').toggleClass('show');
        }
    });

    $('#askquestion').on('click',function (e) { 
        e.preventDefault();
        $('#action').val('askquestion');
        if(checksession.success){
            $('#f_token').val(checksession.data);
            urlref();
        }else{
            $('#form-modal-token').toggleClass('show');
        }
        });

        $('#submit').on('click',function (e) { 
        e.preventDefault();
        urlref();
    });

    function urlref() { 
        var f_noreg = "{{ $report->f_noreg }}";
        var f_token = $('#f_token').val();
        var action = $('#action').val();

        $.ajax({
            type: "POST",
            url: "{{route('tokenverification')}}",
            data: {
                _token:'{{csrf_token()}}',
                f_token:f_token,
                f_noreg:f_noreg,
                action:action
            },
            dataType: "json",
            success: function (response) {
                if(response.result){
                    var url = response.data.url;
                    location.href = url; 
                }else{
                    $('#form-modal-token').toggleClass('show');
                    $('#f_token').val('');
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
        }

</script>
    
@endsection