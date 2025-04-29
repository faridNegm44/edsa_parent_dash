@extends('back.layouts.app')

@section('title') تعديل طلب / إضافة تعليق @endsection


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
            <h4 class="content-title mb-2">تعديل طلب / إضافة تعليق
        </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ url('dashboard/parent_problems') }}">جميع الرسائل / الطلبات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تعديل طلب / إضافة تعليق</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12" id="page_content">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        تعديل طلب / إضافة تعليق
                    </h4>
                </div>
            </div>

            <div class="card-body">

                <form>
                    @csrf
                    <input id="res_id" type="hidden" value="{{ $find['id'] }}">
                    <input id="comment_id" type="hidden" value="">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mg-b-20">
                                <label style="margin-bottom: 10px;text-decoration: underline;">تصنيف الطلب</label>
                                @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
                                <select name="problem_type" id="problem_type" class="form-control">
                                    <option value="">---</option>
                                    @foreach (\App\Models\ProblemType::all() as $item)
                                        <option value="{{ $item->id }}" {{ $item->id ==  $find['problem_type'] ? "selected" : null }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @else
                                    <select name="problem_type" id="problem_type" class="form-control">
                                        <option value="">---</option>
                                        @foreach (\App\Models\ProblemType::where('show_to_parent', 1)->get() as $item)
                                            <option value="{{ $item->id }}" {{ $item->id ==  $find['problem_type'] ? "selected" : null }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <p class="errors" id="errors-problem_type"></p>
                            </div>

                            @if (auth()->user()->user_status == 1)
                                <div class="form-group mg-b-20">
                                    <label style="margin-bottom: 10px;text-decoration: underline;"> تاريخ إضافة الطلب</label>
                                    <input type="datetime-local" class="form-control" name="created_at" value="{{ $find['created_at'] }}"/>
                                    <p class="errors" id="errors-problem_type"></p>
                                </div>

                                <div class="form-group mg-b-20">
                                    <label style="margin-bottom: 10px;text-decoration: underline;">تاريخ غلق الطلب</label>
                                    <input type="datetime-local" class="form-control" name="ended_at" value="{{ $find['ended_at'] }}"/>
                                    <p class="errors" id="errors-problem_type"></p>
                                </div>
                            @endif

                            @if (auth()->user()->user_status != 3)
                                <div class="form-group mg-b-20">
                                    <label style="margin-bottom: 10px;text-decoration: underline;" for="readed">تمت القراءة</label>
                                    <input type="checkbox" name="readed" id="readed" value="1" {{ $find['readed']  == 1 ? 'checked' : null }} style="position: relative;top: 3px; right: 7px;">
                                </div>
                            @endif
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
                                            <option value="{{ $item->ID }}" {{ $find['parent_id'] == $item->ID ? 'selected' : null }}>{{ $item->TheName0 }} ( {{ ( $item->ThePhone1 ) }} )</option>
                                        @endforeach
                                    </select>
                                    <p class="errors" id="errors-parent_id"></p>
                                </div>
                                <br>
                            @endif
                            <div class="form-group mg-b-20">
                                <label for="problem" style="margin-bottom: 10px;text-decoration: underline;"> مضمون الرسالة</label>
                                <textarea class="form-control" name="problem" id="problem" placeholder="مضمون الرسالة" rows="6">{{ $find['problem'] }}</textarea>
                                <p class="errors" id="errors-problem"></p>
                            </div>
                            <div class="form-group mg-b-20">
                                <button class="btn btn-main-primary btn-block" id="send_problem">تعديل الطلب</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        {{-- Comments Card --}}
        <div class="card" id="comments_card">
            <div class="card-body pd-t-0">

                {{-- Comment Form --}}
                <form id="comment_form" enctype="multipart/form-data">
                    @csrf
                    <div class="pd-30 pd-sm-40 bg-gray-100">
                        <div class="row row-xs">
                            <input type="hidden" name="parent_id_input" value="{{ $find['parent_id'] }}">
                            <div class="col-md-9" style="margin-bottom: 10px;">
                                <textarea class="form-control" name="comment" id="comment" placeholder="أضف تعليق" rows="4" style="resize: vertical;"></textarea>

                                <input type="text" hidden id="comment_hidden" name="comment_hidden">
                                <p class="errors" id="errors-comment"></p>
                            </div>

                            <div class="col-md-3">
                                <input class="form-control" type="file" name="file" id="file">
                                <input class="form-control" type="hidden" name="old_file" id="old_file" value="">
                                <br>
                                <button class="btn btn-main-primary btn-block" id="add_comment">
                                    أضف تعليق
                                </button>

                                <button class="btn btn-success btn-block" id="update_comment" style="display: none;">
                                    تعديل التعليق
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <br>
                <br>

                <div id="comments_area">
                    <div class="card-header pd-t-25">
                        <h3 class="card-title badge badge-primary">
                            {{ count($comments) }}:
                            <span style="margin: 0px 3px;">تعليق</span>
                        </h3>
                    </div>

                    @foreach ($comments as $comment)
                        <div class="d-sm-flex p-4 mt-4 border sub-review-section rounded-5" style="background: rgb(233, 237, 255);">
                            <div class="d-flex mr-3">
                                <div class="avatar avatar-md brround bg-primary">
                                    {{ mb_substr($comment->user['name'], 0, 1, 'utf8') }}
                                </div>
                            </div>
                            <div class="media-body" style="position: relative;">
                                <h6 class="mt-0 mb-1 font-weight-semibold" style="margin: 5px 10px;font-size: 16px;font-weight: bold;text-decoration: underline;">
                                    {{ $comment->user['name'] }}

                                    @if ($comment['file'])
                                        <span style="margin: 0px 10px;font-size: 13px;">
                                            <a style="color:brown;display: block;" href="{{ url('back/files/comments/'.$comment['file']) }}" download>( {{ $comment['file'] }} )</a>
                                        </span>
                                    @else

                                    @endif
                                </h6>


                                @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
                                    <div class="card-options ml-auto" style="position: absolute;left: 0px;top: -2px;">
                                        <div class="btn-group ml-5 mb-0 show">
                                            <a class="btn-link option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#"><i class="fe fe-more-vertical text-danger" style="font-weight: bold;"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right shadow " x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-148px, 5px, 0px);">

                                                @if ($comment->edited_comment == null)
                                                    <a class="dropdown-item edit_comment" res_id="{{ $comment->id }}"><i class="fe fe-edit mr-2" style="padding: 5px;"></i>تعديل</a>
                                                @endif
                                                <a class="dropdown-item text-danger delete_comment" res_id="{{ $comment->id }}"><i class="fe fe-trash mr-2" style="padding: 5px;"></i>حذف</a>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(auth()->user()->user_status == 3)
                                    @if (auth()->user()->id === $comment->commented_by)
                                        <div class="card-options ml-auto" style="position: absolute;left: 0px;top: -2px;">
                                            <div class="btn-group ml-5 mb-0 show">
                                                <a class="btn-link option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#"><i class="fe fe-more-vertical text-danger" style="font-weight: bold;"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right shadow " x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-148px, 5px, 0px);">

                                                    @if ($comment->edited_comment == null)
                                                        <a class="dropdown-item edit_comment" res_id="{{ $comment->id }}"><i class="fe fe-edit mr-2" style="padding: 5px;"></i>تعديل</a>
                                                    @endif
                                                    <a class="dropdown-item text-danger delete_comment" res_id="{{ $comment->id }}"><i class="fe fe-trash mr-2" style="padding: 5px;"></i>حذف</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif


                                <p class="mb-2 mt-2" style="margin: 5px 10px 15px;font-size: 14px;">
                                    @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
                                        {{ $comment->comment }}
                                    @elseif(auth()->user()->user_status == 3)
                                        @if ($comment->edited_comment != null)
                                            {{ $comment->edited_comment }}
                                        @else
                                            {{ $comment->comment }}
                                        @endif
                                    @endif
                                </p>


                                @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
                                    @if ($comment->edited_comment != null)
                                        <hr>
                                        <p class="mb-2 mt-2" style="margin: 5px 40px 15px;font-size: 16px;color: rgb(194, 69, 31);font-weight:bold;">
                                            {{ $comment->edited_comment }}
                                        </p>
                                    @endif
                                @endif

                                <a class="mr-2 mt-1">
                                    <span class="badge badge-light" style="font-size: 13px;">
                                        تاريخ الإرسال :
                                        <span>{{ $comment->created_at->format('h:i:s') }}</span>
                                        <span style="margin: 0px 7px;">{{ $comment->created_at->format('Y-m-d') }}</span>
                                    </span>
                                </a>

                                @if ($comment->created_at == $comment->updated_at)

                                @else
                                    <a class="mr-2 mt-1">
                                        <span class="badge badge-light" style="font-size: 13px;">
                                            أخر تحديث :
                                            <span>{{ $comment->updated_at == null ? null : $comment->updated_at->format('h:i:s') }}</span>
                                            <span style="margin: 0px 7px;">{{ $comment->updated_at == null ? null : $comment->updated_at->format('Y-m-d') }}</span>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
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

    {{-- Update Problem --}}
    <script>
        $("#send_problem").click(function(e) {
            e.preventDefault();
            let id = $('#res_id').val();
            let act = "{{ url('dashboard/parent_problems/update') }}"+"/"+id;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('form').serialize(),
                success: function (res) {
                    notif({
                        msg: "تم تعديل الطلب بنجاح",
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








    {{-- Start Comment Area --}}
        {{-- Store Comment --}}
        <script>
            $("#add_comment").click(function(e) {
                e.preventDefault();
                let id = $('#res_id').val();
                let act = "{{ url('dashboard/parent_problems/store_comment') }}"+"/"+id;

                $.ajax({
                    type: "post",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: act,
                    processData: false,
                    contentType: false,
                    data: new FormData($('#comment_form')[0]),
                    success: function (res) {
                        notif({
                            msg: "تم التعليق بنجاح",
                            type: "success",
                        });

                        $("#comment_form textarea").val('');
                        $("#comment_form #file").val('');
                        // $("#comments_area").load(window.location + " #comments_area");
                        window.location.reload();
                    },
                    error: function (res) {
                        notif({
                            msg: "هناك شيء ما خطأ",
                            type: "error",
                        });
                        if(res.responseJSON.errors.comment){
                            $("form #errors-comment").css('display' , 'block').text(res.responseJSON.errors.comment);
                        }else{
                            $("form #errors-comment").text('');
                        }
                    }
                });
            });
        </script>

        {{-- Edit Comment --}}
        <script>
            $(".edit_comment").click(function(e) {
                e.preventDefault();
                let id = $(this).attr('res_id');
                let act = "{{ url('dashboard/parent_problems/edit/comment') }}"+"/"+id;

                $.ajax({
                    type: "get",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: act,
                    processData: false,
                    contentType: false,
                    data: new FormData($('#comment_form')[0]),
                    success: function (res) {
                        $("#comments_card textarea").val(res.comment);
                        $("#comment_hidden").val(res.comment);
                        $("#comments_card #old_file").val(res.file);
                        $("#comment_id").val(id);
                        $("#update_comment").css('display', 'block');
                        $("#add_comment").css('display', 'none');

                        notif({
                            msg: "تم جلب التعليق بنجاح في انتظار التعديل علية",
                            type: "success",
                        });
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

        {{-- Update Comment --}}
        <script>
            $("#update_comment").click(function(e) {
                e.preventDefault();
                let comment = $("#comment").val();
                let comment_hidden = $("#comment_hidden").val();

                if(comment.trim() == comment_hidden){
                    alert('قم بالتعديل علي التعليق قبل عملية الحفظ');
                }else{

                    let id = $("#comment_id").val();
                    let act = "{{ url('dashboard/parent_problems/update_comment') }}"+"/"+id;

                    $.ajax({
                        type: "post",
                        headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        url: act,
                        processData: false,
                        contentType: false,
                        data: new FormData($('#comment_form')[0]),
                        success: function (res) {
                            notif({
                                msg: "تم تعديل التعليق بنجاح",
                                type: "success",
                            })
                            $("#comment_form textarea").val('');
                            $("#comment_form #file").val('');
                            window.location.reload();
                        },
                        error: function (res) {
                            notif({
                                msg: "هناك شيء ما خطأ",
                                type: "error",
                            });
                            if(res.responseJSON.errors.comment){
                                $("form #errors-comment").css('display' , 'block').text(res.responseJSON.errors.comment);
                            }else{
                                $("form #errors-comment").text('');
                            }
                        }
                    })
                }
            });
        </script>

        {{-- Delete Comment --}}
        <script>
            $(".delete_comment").click(function(e) {
                e.preventDefault();
                let id = $(this).attr('res_id');
                let act = "{{ url('dashboard/parent_problems/delete/comment') }}"+"/"+id;

                if(confirm('هل أنت متأكد من حذف التعليق') == true){
                    $.ajax({
                        type: "get",
                        headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        url: act,
                        success: function (res) {
                            notif({
                                msg: "تم الحذف بنجاح",
                                type: "error",
                            });

                            window.location.reload();
                        },
                        error: function (res) {
                            notif({
                                msg: "هناك شيء ما خطأ",
                                type: "error",
                            });
                        }
                    });
                }
            });
        </script>

        {{-- check if textarea value null or not by keyup--}}
        <script>
            $('#comment_form textarea').on('focusout keyup', function () {
                if($(this).val() == '' && $("#add_comment").css('display', 'none')){
                    $("#update_comment").css('display', 'none');
                    $("#add_comment").css('display', 'block');
                }
            });
        </script>

    {{-- End Comment Area --}}



    @include('back.user.delete');

@endsection
