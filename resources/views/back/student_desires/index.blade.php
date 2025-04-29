@extends('back.layouts.app')

@section('title') رغبات الطلاب @endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
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
    
    <script>
        $('#example2').DataTable({
            processing: true,
            serverSide: true,
            language: {
                sUrl : "{{ url('back/assets/js/ar.json') }}"
            },
            ajax: "{{ url('dashboard/students/datatable_students_desires') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'classroom', name: 'classroom'},
                {data: 'subjects', name: 'subjects'},
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

    @include('back.student_desires.delete');
    
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">رغبات الطلاب</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">رغبات الطلاب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">رغبات الطلاب</h4>
                    <div class="col-xs-6 d-flex">
                        <a class="btn btn-primary btn-icon btn-sm text-white mr-2 modal-effect bt_modal" act="{{ url('dashboard/students/create_desires') }}" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8"><i class="fe fe-plus"></i></a>
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>كود الطالب</th>
                                <th>اسم الطالب</th>
                                <th>الصف الدراسي / الدوره التعليميه</th>
                                <th>رغبات الطالب</th>
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

@endsection