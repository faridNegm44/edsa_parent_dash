@extends('back.layouts.app')

@section('title')

    @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
        إشعارات لصف دراسي أو أكثر
    @elseif(auth()->user()->user_status == 3)
        إشعارات خاصة بالمواد والصفوف الدراسية   
    @endif
 
 @endsection


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
        .select2-selection--multiple{
            height: 150px;
            overflow: auto;
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
                ajax: "{{ url('dashboard/noti_to_class/datatable_noti_to_class') }}",
                columns: [
                    {data: 'group_id', name: 'group_id'},
                    {data: 'class_id', name: 'class_name'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'sender', name: 'sender'},
                    {data: 'status', name: 'status'},
                    {data: 'readed', name: 'readed'},
                    {data: 'created_at', name: 'created_at'},
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
                ajax: "{{ url('dashboard/noti_to_class/datatable_noti_to_class') }}",
                columns: [
                    {data: 'class_id', name: 'class_name'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'sender', name: 'sender'},
                    {data: 'readed', name: 'readed'},
                    {data: 'created_at', name: 'created_at'},
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
        $(document).on('click', '.change_readed', function(){
            let id = $(this).attr('res_id'); 
            let act = "{{ url('dashboard/noti_to_class/change_readed') }}"+"/"+id;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('form').serialize(),
                success: function (res) {          
                    $('#example2').DataTable().ajax.reload( null, false );          
                    // notif({
                    //     msg: "تمت القراءة بنجاح",
                    //     type: "success",
                    // });
                }
            });
        })
    </script>
    @include('back.noti_to_class.delete');
    
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">
                @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                    إشعارات لصف دراسي أو أكثر
                @elseif(auth()->user()->user_status == 3)
                    إشعارات خاصة بالمواد والصفوف الدراسية   
                @endif
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                            إشعارات لصف دراسي أو أكثر
                        @elseif(auth()->user()->user_status == 3)
                            إشعارات خاصة بالمواد والصفوف الدراسية   
                        @endif
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                            إشعارات لصف دراسي أو أكثر
                        @elseif(auth()->user()->user_status == 3)
                            إشعارات خاصة بالمواد والصفوف الدراسية   
                        @endif
                    </h4>
                    @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                        <div class="col-xs-6 d-flex">
                            <a class="btn btn-primary btn-icon btn-sm text-white mr-2 modal-effect bt_modal" act="{{ url('dashboard/noti_to_class/create') }}" data-effect="effect-sign" data-toggle="modal" href="#modaldemo8"><i class="fe fe-plus"></i></a>
                        </div>
                    @elseif(auth()->user()->user_status == 3)

                    @endif                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                        @if(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                            <thead>
                                <tr>
                                    <th>المجموعة / حذف - تعديل</th>
                                    <th>الصف الدراسي</th>
                                    <th>عنوان الرسالة</th>
                                    <th style="width: 30%;">وصف الرسالة</th>
                                    <th>المرسل</th>
                                    <th>الحاله</th>
                                    <th>تمت القراءة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>أكشن</th>
                                </tr>
                            </thead>
                        @elseif(auth()->user()->user_status == 3)
                            <thead>
                                <tr>
                                    <th>الصف الدراسي</th>
                                    <th>عنوان الرسالة</th>
                                    <th style="width: 30%;">وصف الرسالة</th>
                                    <th>المرسل</th>
                                    <th>تمت القراءة</th>
                                    <th>تاريخ الإنشاء</th>
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

@endsection