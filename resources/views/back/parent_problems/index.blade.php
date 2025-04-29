@extends('back.layouts.app')

@section('title') جميع الرسائل / الطلبات @endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        /* table thead{
            font-size: calc(auto - 50%);
        } */
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
        tr td:nth-child(1){
            width: 10%;
        }
        tr td:nth-child(2){
            width: 30%;
        }
        tr td:nth-child(3){
            width: 15%;
        }
        tr td:nth-child(4){
            width: 15%;
        }
        tr td:nth-child(5){
            width: 15%;
        }
        tr td:nth-child(6){
            width: 15%;
        }
</style>
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">جميع الرسائل / الطلبات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">جميع الرسائل / الطلبات</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        جميع الرسائل / الطلبات
                    </h4>
                    <div class="col-xs-6 d-flex">
                        <a class="btn btn-primary btn-icon btn-sm text-white mr-2" href="{{ url('dashboard/parent_problems/create') }}"><i class="fe fe-plus"></i></a>
                    </div>

                </div>
            </div>

            <div class="card-body">
                @if (auth()->user()->user_status == 1)
                    <div class="panel panel-primary tabs-style-3">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs" style="font-size: 13px;" id="panel-tabs">
                                    <li>
                                        <a href="#tab11" class="active" data-toggle="tab">
                                            جميع الطلبات
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab12" data-toggle="tab">
                                            عاجله
                                            <span class="badge badge-danger" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('problem_status' , 'عاجل')->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#tab13" data-toggle="tab">
                                           جاري حلها
                                           <span class="badge badge-light" style="font-size: 14px;">
                                               {{ App\Models\ParentProblems::where('problem_status' , 'جاري حلها')->count() }}
                                           </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab14" data-toggle="tab">
                                            تم حلها
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('problem_status' , 'تم حلها')->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab15" data-toggle="tab">
                                            تم الغائها
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('problem_status' , 'تم الإلغاء')->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        @if (App\Models\ParentProblems::where('deadline', '<',  \Carbon\Carbon::now())->count() > 0)
                                            <a href="#tab16" class="tab16" data-toggle="tab" style="background: rgb(250, 91, 91);color: #fff;">
                                                مهام متأخرة
                                                <span class="badge badge-light" style="font-size: 14px;">
                                                    {{ App\Models\ParentProblems::where('deadline', '<',  \Carbon\Carbon::now())->count() }}
                                                </span>
                                            </a>
                                        @else
                                            <a href="#tab16" data-toggle="tab" class="tab16">
                                                مهام متأخرة
                                            </a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab11">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab12">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="urgent" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab13">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="waiting" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab14">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="resolved" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab15">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="canceled" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab16">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="deadline_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
                    <div class="panel panel-primary tabs-style-3">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs" style="font-size: 13px;" id="panel-tabs">
                                    <li>
                                        <a href="#tab11" class="active" data-toggle="tab">
                                            جميع الطلبات
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('staff_id', auth()->user()->id)->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab12" data-toggle="tab">
                                            عاجله
                                            <span class="badge badge-danger" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('problem_status' , 'عاجل')->where('staff_id', auth()->user()->id)->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#tab13" data-toggle="tab">
                                        جاري حلها
                                        <span class="badge badge-light" style="font-size: 14px;">
                                            {{ App\Models\ParentProblems::where('problem_status' , 'جاري حلها')->where('staff_id', auth()->user()->id)->count() }}
                                        </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab14" data-toggle="tab">
                                            تم حلها
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('problem_status' , 'تم حلها')->where('staff_id', auth()->user()->id)->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab15" data-toggle="tab">
                                            تم الغائها
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('problem_status' , 'تم الإلغاء')->where('staff_id', auth()->user()->id)->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab16" data-toggle="tab" class="tab16">
                                            مهام متأخرة
                                            <span class="badge badge-light" style="font-size: 14px;">
                                                {{ App\Models\ParentProblems::where('deadline', '<', \Carbon\Carbon::now())->where('staff_id', auth()->user()->id)->count() }}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab11">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="example2" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab12">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="urgent" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab13">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="waiting" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab14">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="resolved" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab15">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="canceled" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab16">
                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="deadline_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>إسم المرسل</th>
                                                    <th>الطلب</th>
                                                    <th>إسناد إلي</th>
                                                    <th>تقيم الطلب</th>
                                                    <th>تقيم الموظف</th>
                                                    <th>حالة المشكلة</th>
                                                    <th>
                                                        تاريخ انشاء / اغلاق الطلب
                                                    </th>
                                                    <th>أكشن</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (auth()->user()->user_status == 3)
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-striped table-bordered text-center" id="parent_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>تعليقات</th>
                                    <th>الطلب</th>
                                    <th>إسناد إلي</th>
                                    <th>حالة المشكلة</th>
                                    <th>
                                        تاريخ 
                                    </th>
                                    <th>أكشن</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endif

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


@section('footer')
    <script src="{{ url('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('back') }}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('back') }}/assets/js/select2.js"></script>
    <script src="{{ url('back') }}/assets/js/modal.js"></script>


    <script>
        $(document).ready(function () {
            $("body").addClass('sidenav-toggled');
        });
    </script>

    @if (auth()->user()->user_status == 1)
        {{-- All --}}
        <script>
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- Urgent --}}
        <script>
            $('#urgent').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_urgent') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- waiting --}}
        <script>
            $('#waiting').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_waiting') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- resolved --}}
        <script>
            $('#resolved').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_resolved') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- canceled --}}
        <script>
            $('#canceled').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_canceled') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- deadline_table --}}
        <script>
            $('#deadline_table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_deadline') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

    @elseif(auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
        {{-- All --}}
        <script>
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- Urgent --}}
        <script>
            $('#urgent').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_urgent') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- waiting --}}
        <script>
            $('#waiting').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_waiting') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- resolved --}}
        <script>
            $('#resolved').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_resolved') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- canceled --}}
        <script>
            $('#canceled').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_canceled') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>

        {{-- deadline_table --}}
        <script>
            $('#deadline_table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems_deadline') }}",
                columns: [
                    {data: 'parent_id', name: 'parent_id'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_rating', name: 'problem_rating'},
                    {data: 'staff_rating', name: 'staff_rating'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[6, "DESC"]]
            });
        </script>
    @elseif(auth()->user()->user_status == 3)
        {{-- All --}}
        <script>
            $('#parent_table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    sUrl : "{{ url('back/assets/js/ar.json') }}"
                },
                ajax: "{{ url('dashboard/parent_problems/datatable_parent_problems') }}",
                columns: [
                    {data: 'comments_count', name: 'comments_count'},
                    {data: 'problem', name: 'problem'},
                    {data: 'staff_id_date_reference', name: 'staff_id_date_reference'},
                    {data: 'problem_status', name: 'problem_status'},
                    {data: 'created_at_ended_at', name: 'created_at_ended_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[0, "DESC"]]
            });
        </script>
    @endif


    {{-- open and close modal --}}
    <script>
        $(document).on('click', '.bt_modal', function (e) {
            e.preventDefault();
            let act = $(this).attr('act');

            $('#modaldemo8').modal();
            $('#modal_content').load(act);
        });
    </script>


    <script>
        // {{-- change_problem_rating --}}
            $(document).on('change', '.change_problem_rating', function (e) {
                e.preventDefault();
                let id = $(this).attr('res_id');
                let problem_rating = $(this).val();
                let act = "{{ url('dashboard/parent_problems/update_problem_rating') }}"+"/"+id;

                $.ajax({
                    type: "get",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: act,
                    data: {
                        problem_rating: problem_rating
                    },
                    success: function (res) {
                        $('#example2').DataTable().ajax.reload( null, false );
                        $('#urgent').DataTable().ajax.reload( null, false );
                        $('#resolved').DataTable().ajax.reload( null, false );
                        $('#waiting').DataTable().ajax.reload( null, false );
                        $('#deadline_table').DataTable().ajax.reload( null, false );
                        $('#canceled').DataTable().ajax.reload( null, false );

                        notif({
                            msg: "تم تغير حاله الطلب بنجاح",
                            type: "success",
                        });
                    },
                    error: function (res) {

                    }
                });
            });



        // {{-- change_problem_status --}}
            $(document).on('change', '.change_problem_status', function (e) {
                e.preventDefault();
                let id = $(this).attr('res_id');
                let problem_status = $(this).val();
                let act = "{{ url('dashboard/parent_problems/update_problem_status') }}"+"/"+id;

                $.ajax({
                    type: "get",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: act,
                    data: {
                        problem_status: problem_status
                    },
                    success: function (res) {
                        $('#example2').DataTable().ajax.reload( null, false );
                        $('#urgent').DataTable().ajax.reload( null, false );
                        $('#resolved').DataTable().ajax.reload( null, false );
                        $('#waiting').DataTable().ajax.reload( null, false );
                        $('#deadline_table').DataTable().ajax.reload( null, false );
                        $('#canceled').DataTable().ajax.reload( null, false );

                        notif({
                            msg: "تم تغير حاله الطلب إلي عاجل بنجاح",
                            type: "success",
                        });

                        $("#panel-tabs").load(window.location + " #panel-tabs");
                    },
                    error: function (res) {

                    }
                });
            });



         // {{-- change_staff_rating --}}
            $(document).on('change', '.change_staff_rating', function (e) {
                e.preventDefault();
                let id = $(this).attr('res_id');
                let staff_rating = $(this).val();
                let act = "{{ url('dashboard/parent_problems/update_staff_rating') }}"+"/"+id;

                $.ajax({
                    type: "get",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: act,
                    data: {
                        staff_rating: staff_rating
                    },
                    success: function (res) {
                        $('#example2').DataTable().ajax.reload( null, false );
                        $('#urgent').DataTable().ajax.reload( null, false );
                        $('#resolved').DataTable().ajax.reload( null, false );
                        $('#waiting').DataTable().ajax.reload( null, false );
                        $('#deadline_table').DataTable().ajax.reload( null, false );
                        $('#canceled').DataTable().ajax.reload( null, false );

                        notif({
                            msg: "تم التقيم بنجاح",
                            type: "success",
                        });
                    },
                    error: function (res) {

                    }
                });
            });
    </script>

    <script>
        setInterval(function() {
            location.reload();
        }, 180000);
    </script>

    @include('back.parent_problems.delete');

@endsection
