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
                            <div class="form-group mg-b-20 problem_type">
                                <label>اختر تصنيف لطلبك من هنا</label>
                                @if (auth()->user()->user_status !== 3)
                                    <select name="problem_type" id="problem_type" class="form-control">
                                        <option selected disabled>اختر</option>
                                        @foreach (\App\Models\ProblemType::all() as $item)
                                            {{--<option value="{{ $item->id }}" {{ $item->name == "أخري إدارة" ? "selected" : null }}>{{ $item->name }}</option>--}}
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="problem_type" id="problem_type" class="form-control">
                                        <option selected disabled>اختر</option>
                                        @foreach (\App\Models\ProblemType::where('show_to_parent', 1)->get() as $item)
                                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <p class="errors" id="errors-problem_type"></p>
                            </div>

                            @if (auth()->user()->user_status == 1)
                                <div class="form-group mg-b-20 problem_rating" style="display: none;">
                                    <label>تقيم الطلب </label>
                                    @if (auth()->user()->user_status !== 3)
                                        <select name="problem_rating" id="problem_rating" class="form-control">
                                            {{--<option selected disabled>اختر</option>--}}
                                            <option value="30">سهلة</option>
                                            <option value="40">أقل من المتوسط</option>
                                            <option value="50">متوسط</option>
                                            <option value="90">صعبـة</option>
                                            <option value="100">صعبـة جدآ</option>
                                        </select>
                                    @endif
                                    <p class="errors" id="errors-problem_rating"></p>
                                </div>

                            
                                <div class="form-group mg-b-20">
                                    <label>تاريخ</label>
                                    <input type="datetime-local" class="form-control" name="created_at" value="{{ date('Y-m-d\TH:i') }}"/>
                                    <p class="errors" id="errors-created_at"></p>
                                </div>
                            @endif
                        </div>
                        <br>
                        <br>

                        <div class="col-md-9">
                            @if (auth()->user()->user_status == 3)
                                <div class="form-group mg-b-20 d-none">
                                    <label for="parent_id"> ولي الأمر</label>
                                    <select name="parent_id" id="parent_id" class="form-control" style="width: 100%;">
                                        <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                    </select>
                                    <p class="errors" id="errors-parent_id"></p>
                                </div>
                            @else
                                <div class="form-group mg-b-20">
                                    <label for="parent_id"> ولي الأمر</label>
                                    <select name="parent_id" id="parent_id" class="form-control select2_select2" style="width: 100%;">
                                        <option selected disabled>اختر</option>
                                        @foreach ($parents as $item)
                                            <option value="{{ $item->ID }}">{{ $item->TheName0 }} - {{ $item->ThePhone1 }}</option>
                                        @endforeach
                                    </select>
                                    <p class="errors" id="errors-parent_id"></p>
                                </div>
                                <br>
                            @endif
                            <div class="form-group mg-b-20">
                                <label for="problem"> مضمون الرسالة</label>
                                <textarea class="form-control" name="problem" id="problem" placeholder="مضمون الرسالة" rows="6"></textarea>
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
        $(".problem_type select").change(function () {
            let id = $(this).val();
            let act = "{{ url('dashboard/parent_problems/get_problem_rating') }}"+"/"+id;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('form').serialize(),
                success: function (res) {
                    $(".problem_rating").css('display', 'block');
                    $(".problem_rating select").val(res.rate).attr('selected');
                },
                error: function (res) {
                    notif({
                        msg: "هناك شيء ما خطأ",
                        type: "error",
                    });
                }
            });
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
                        
                        $("#send_problem").remove();
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

    @include('back.user.delete');

@endsection
