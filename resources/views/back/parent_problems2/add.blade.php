@extends('back.layouts.app')

@section('title') إنشاء طلب @endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/quill/quill.snow.css" rel="stylesheet">
	<link href="{{ url('back') }}/assets/plugins/quill/quill.bubble.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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



@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">إنشاء طلب</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ url('dashboard/parent_problems') }}">جميع الرسائل / الطلبات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">إنشاء طلب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        إنشاء طلب
                    </h4>
                </div>
            </div>
            <div class="card-body">

                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mg-b-20">
                                <label style="margin-bottom: 10px;text-decoration: underline;">تصنيف الطلب</label>
                                <select name="problem_type" id="problem_type" class="form-control">
                                    <option value="">---</option>
                                    <option value="شكوي من الإدارة">شكوي من الإدارة</option>
                                    <option value="شكوي من مدرس">شكوي من مدرس</option>
                                    <option value="نقل إلي جروب أخر">نقل إلي جروب أخر</option>
                                    <option value="الإشتراك في مادة أخري">الإشتراك في مادة أخري</option>
                                    <option value="إقتراحات">إقتراحات</option>
                                    <option value="أخري">أخري</option>
                                </select>
                                <p class="errors" id="errors-problem_type"></p>
                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="col-md-9">
                            @if (auth()->user()->user_status == 3)
                                <div class="form-group mg-b-20">
                                    <label for="parent_id" style="margin-bottom: 10px;text-decoration: underline;"> ولي الأمر</label>
                                    <select name="parent_id" id="parent_id" class="form-control" style="width: 100%;">
                                        <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                    </select>
                                    <p class="errors" id="errors-parent_id"></p>
                                </div>
                                <br>
                            @else
                                <div class="form-group mg-b-20">
                                    <label for="parent_id" style="margin-bottom: 10px;text-decoration: underline;"> ولي الأمر</label>
                                    <select name="parent_id" id="parent_id" class="form-control select2_select2" style="width: 100%;">
                                        @foreach ($parents as $item)
                                            <option value="{{ $item->ID }}">{{ $item->TheName0 }} ( {{ ( $item->ThePhone1 ) }} )</option>
                                        @endforeach
                                    </select>
                                    <p class="errors" id="errors-parent_id"></p>
                                </div>
                                <br>
                            @endif
                            <div class="form-group mg-b-20">
                                <label for="problem" style="margin-bottom: 10px;text-decoration: underline;"> مضمون الرسالة</label>
                                {{-- <div class="ql-wrapper ql-wrapper-demo bg-gray-100">
                                    <div id="quillEditor" style="background: #FFF;" name="problem">
                                    </div>
                                </div> --}}
                                <textarea class="summernote form-control" name="problem" id="problem"></textarea>
                                <p class="errors" id="errors-problem"></p>
                            </div>
                            <div class="form-group mg-b-20">
                                <button class="btn btn-main-primary btn-block" id="send_problem">إرسال الطلب</button>
                            </div>
                        </div>
                    </div>
                </form>

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



@section('footer')
    <script src="{{ url('back') }}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('back') }}/assets/js/select2.js"></script>
    <script src="{{ url('back') }}/assets/js/modal.js"></script>
    <script src="{{ url('back') }}/assets/js/form-editor.js"></script>
    <script src="{{ url('back') }}/assets/js/summernote.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".select2_select2").select2();
        });
    </script>

    <script>
        $("#send_problem").click(function(e) {
            e.preventDefault();

                let act = "{{ url('dashboard/parent_problems/store') }}";
                $.ajax({
                    type: "post",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: act,
                    data: $('form').serialize(),
                    success: function (res) {
                        notif({
                            msg: "تم إرسال الطلب بنجاح",
                            type: "success",
                        });

                        window.location.href = "{{ url('dashboard/parent_problems') }}";
                    },
                    error: function (res) {

                        notif({
                            msg: "هناك شيء ما خطأ",
                            type: "error",
                        });

                        if(res.responseJSON.errors.problem_type){
                            $("form #errors-problem_type").css('display' , 'block').text(res.responseJSON.errors.problem_type);
                        }else{
                            $("form #errors-problem_type").text('');
                        }
                        if(res.responseJSON.errors.problem){
                            $("form #errors-problem").css('display' , 'block').text(res.responseJSON.errors.problem);
                        }else{
                            $("form #errors-problem").text('');
                        }
                        if(res.responseJSON.errors.parent_id){
                            $("form #errors-parent_id").css('display' , 'block').text(res.responseJSON.errors.parent_id);
                        }else{
                            $("form #errors-parent_id").text('');
                        }
                    }
                });
        });
    </script>

    {{-- Run summernote --}}
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'اكتب طلب حضرتك هنا باللغة العربية',
                height: 200
            });
        });
    </script>

    @include('back.user.delete');

@endsection
