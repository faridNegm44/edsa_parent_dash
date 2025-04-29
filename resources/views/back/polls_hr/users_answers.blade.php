@extends('back.layouts.app')

@section('title') {{ $nameAr }}@endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection

@section('footer')
    <script src="{{ url('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('back') }}/assets/js/modal.js"></script>
    
    <script>
        $('#example2').DataTable({
            processing: true,
            serverSide: true,
            language: {
                sUrl : "{{ url('back/assets/js/ar.json') }}"
            },
            ajax: `{{ url('dashboard/polls_hr/users_answers_datatable') }}`,
            columns: [
                {data: 'user', name: 'user'},
                {data: 'created_at', name: 'created_at'},
                {data: 'group', name: 'group'},
                {data: 'question', name: 'question'},
                {data: 'question_value', name: 'question_value'},
                {data: 'answers', name: 'answers'},
                {data: 'answer_value', name: 'answer_value'},
                {data: 'answer_value_percentage', name: 'answer_value_percentage'},
            ],
            order: [[0, "DESC"]]
        });            
    </script>

    <script>
        $(document).ready(function () {
            $("body").addClass('sidenav-toggled');
        });
    </script>
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">{{ $nameAr }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $nameAr }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        {{ $nameAr }}
                    </h4>                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 10%;">المستخدم</th>
                                <th style="width: 10%;">وقت التقييم</th>
                                <th style="width: 20%;">المجموعة</th>
                                <th style="width: 20%;">السؤال</th>
                                <th style="width: 10%;">قيمة السؤال</th>
                                <th style="width: 15%;">الإجابة</th>
                                <th style="width: 5%;">قيمة الإجابة</th>
                                <th style="width: 10%;">نسبة الإجابة من السؤال</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    
    
    {{-- Add Or Edit Modal --}}
    <div class="modal fade" id="modaldemo8">
        <div class="modal-dialog modal-lg" role="document">
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