@extends('back.layouts.app')

@section('title') الطلاب @endsection


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
    
    @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
        <script>
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/students/datatable_students') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'desires', name: 'desires'},
                    {data: 'parent', name: 'parent'},
                    {data: 'name', name: 'name'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'TheEduType', name: 'TheEduType'},
                    {data: 'TheTestType', name: 'TheTestType'},
                    {data: 'nationality', name: 'nationality'},
                    {data: 'city', name: 'city'},
                    // {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[0, "DESC"]]
            });
        </script>
    @elseif(auth()->user()->user_status == 3)
        <script>
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/students/datatable_students') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'desires', name: 'desires'},
                    // {data: 'parent', name: 'parent'},
                    {data: 'name', name: 'name'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'TheEduType', name: 'TheEduType'},
                    {data: 'TheTestType', name: 'TheTestType'},
                    {data: 'nationality', name: 'nationality'},
                    {data: 'city', name: 'city'},
                    // {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[0, "DESC"]]
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.bt_modal', function (e) {
            e.preventDefault();
            let act = $(this).attr('act');

            $('#modaldemo8').modal();
            $('#modal_content').load(act);
        });
    </script>
    
    <script>
        $(document).on('click', '.bt_modal2', function (e) {
            e.preventDefault();
            let act = $(this).attr('act');

            $('#modaldemo8').modal();
            $('#modal_content').load(act);
        });
    </script>

    <script>
        $(document).ready(function(){
            $("#modaldemo9").modal('show');
        });
    </script>
    @include('back.student.delete');
    
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">الطلاب</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">الطلاب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)                    
                        <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                            جميع الطلاب 
                        </h4>
                    @elseif(auth()->user()->user_status == 3)                    
                        <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                            جميع الطلاب لولي أمر <span style="color: red;text-decoration: underline;font-weight: bold;">: {{ auth()->user()->name }} </span>
                        </h4>
                    @endif
                    <div class="col-xs-6 d-flex">
                        <a class="btn btn-warning btn-icon btn-sm text-white mr-2 modal-effect" data-effect="effect-sign" data-toggle="modal" href="#modaldemo9"><i class="fa fa-video"></i></a>

                        <a class="btn btn-primary btn-icon btn-sm text-white mr-2 modal-effect bt_modal" act="{{ url('dashboard/students/create') }}" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8"><i class="fe fe-plus"></i></a>
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                        @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                            <thead>
                                <tr>
                                    <th >كود</th>
                                    <th >رغبات</th>
                                    <th class="parent">ولي الأمر</th>
                                    <th>اسم الطالب</th>
                                    <th>موبايل الطالب</th>
                                    <th>نظام التعلم</th>
                                    <th>نظام الإختبارات</th>
                                    <th>الجنسيه</th>
                                    <th>مكان الإقامه</th>
                                    <th>أكشن</th>
                                </tr>
                            </thead>
                        @elseif(auth()->user()->user_status == 3)
                            <thead>
                                <tr>
                                    <th >كود</th>
                                    <th >رغبات</th>
                                    <th>اسم الطالب</th>
                                    <th>موبايل الطالب</th>
                                    <th>نظام التعلم</th>
                                    <th>نظام الإختبارات</th>
                                    <th>الجنسيه</th>
                                    <th>مكان الإقامه</th>
                                    <th>أكشن</th>
                                </tr>
                            </thead>
                        @endif
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

    {{-- Modal Video How To Add New Student --}}
    <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title2" id="exampleModalLabel">فديو توضيحي لكيفية تسجيل وتعديل رغبات الطلبة</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="400px" src="https://www.youtube.com/embed/Oroaq4wKzGM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
@endsection