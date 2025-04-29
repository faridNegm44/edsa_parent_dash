@extends('back.layouts.app')

@section('title') متحصلات من أولياء الأمور @endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/css/file-upload-with-preview.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/css/spotlight.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    
    <style>
        .input-group-text{
            width: 45px;
        }
        .input-group-text i{
            width: 45px;
            text-align: center;
        }
        #ui_notifIt{
            z-index: 100000;
        }
    </style>
@endsection

@section('footer')
    <script src="{{ url('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('back') }}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('back') }}/assets/js/select2.js"></script>
    <script src="{{ url('back') }}/assets/js/modal.js"></script>
    <script src="{{ url('back') }}/assets/js/file-upload-with-preview.min.js"></script>
	
    <script src="{{ url('back') }}/assets/js/spotlight.bundle.js"></script>
    <script src="{{ url('back') }}/assets/js/spotlight.min.js"></script>

    <script>
        $('#example2').DataTable({
            processing: true,
            serverSide: true,
            language: {
                sUrl : "{{ url('back/assets/js/ar.json') }}"
            },
            ajax: "{{ url('dashboard/parents_payments/datatable_parents_payments') }}",
            columns: [
                {data: 'date', name: 'date'},
                {data: 'name', name: 'name'},
                {data: 'amount_by_currency', name: 'amount_by_currency'},
                {data: 'transfer_expense', name: 'transfer_expense'},
                {data: 'amount', name: 'amount'},
                {data: 'pay_type', name: 'pay_type'},
                {data: 'image', name: 'image'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ],
            order: [[0, "DESC"]]
        });
    </script>
    
    <script>
        $(document).on('click', '.bt_modal', function (e) {
            e.preventDefault();
            let act = $(this).attr('act');

            $('#modaldemo8').modal();
            $('#modal_content').load(act);
        });
    </script>

    @include('back.parents_payments.delete');
    
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">متحصلات من أولياء الأمور</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">متحصلات من أولياء الأمور</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        متحصلات من أولياء الأمور
                    </h4>
                    <div class="col-xs-6 d-flex">                        
                        {{-- <a class="btn btn-warning btn-icon btn-sm text-white mr-2 modal-effect" data-effect="effect-sign" data-toggle="modal" href="#modaldemo9"><i class="fa fa-video"></i></a> --}}

                        <a class="btn btn-primary btn-icon btn-sm text-white mr-2 modal-effect bt_modal" act="{{ url('dashboard/parents_payments/create') }}" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8"><i class="fe fe-plus"></i></a>
                    </div>                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>ولي الأمر</th>
                                <th>مبلغ سدده العميل</th>
                                <th>القيمة المستلمة فعلياً</th>
                                <th>مصاريف إدارية</th>
                                <th>طريقة الدفع</th>
                                <th>الإيصال</th>
                                <th>الحاله</th>
                                <th>أكشن</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    
    {{-- Add Or Edit Modal --}}
    <div class="modal fade" id="modaldemo8">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"></h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="modal_content">
                    <div class="spinner-grow text-dark" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Video How To Add Parent Payment --}}
    <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title2" id="exampleModalLabel">فديو توضيحي لكيفية تسجيل دفعة جديدة</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="400px" src="https://www.youtube.com/embed/Er9RjLovjpo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
    </div>
@endsection