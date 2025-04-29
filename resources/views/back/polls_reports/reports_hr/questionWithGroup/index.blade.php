@extends('back.layouts.app')

@section('title') {{ $nameAr }}@endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">

    <style>
        #card_groups select option:disabled{
            font-size: 7px !important;
        }
    </style>
@endsection

@section('footer')
    <script src="{{ url('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('back') }}/assets/js/modal.js"></script>

    <script>
        $(document).ready(function (){ $(".select2_select2").select2(); });
    </script>

    {{-- start script get questions when change group --}}
    <script> 
        $("#poll_hr_group").on("change", function(){
            const questionId = $(this).val();

            let url = "{{ url('dashboard/polls_hr/reports/get_questions_when_change_group') }}"+'/'+questionId;
            
            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                success: function (res) {
                    if(res.length > 0){
                        notif({ msg: "تمت جلب أسئلة المجموعة بنجاح ", type: "success"});
                        
                        $(`#poll_hr_question`).append(`
                            <option value="" disabled selected>إختر سؤال</option>
                        `);

                        $.each(res, function(index, value){
                            $(`#poll_hr_question`).append(`
                                <option value="${value.id}">${JSON.parse(value.question)}</option>
                            `);
                        });
                    }else{
                        notif({ msg: "لاتوجد أسئلة لهذه المجموعة حاليا ", type: "warning"});
                        $(`#poll_hr_question`).append(`
                            <option value="" disabled selected>لاتوجد أسئلة لهذه المجموعة حاليا</option>
                        `);
                    }
                },
                beforeSend:function () {
                    $(`#poll_hr_question option`).remove();
                }
            });
        });
    </script>
    {{-- end script get questions when change group --}}

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

    @if(session()->has('message'))
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>{{ session()->get('message') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="col-xl-12" id="card_groups">
        <div class="card">
            <div class="card-header pb-0 pd-t-25" style="background: #dcdcdc;padding: 30px 20px 30px;">
                <div class="">
                    <form action="{{ url('dashboard/polls_hr/reports/report_question_with_group') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                  <select class="form-control select2_select2" id="poll_hr_group" name="poll_hr_group" style="width: 100%;">
                                    <option value="" disabled selected>إختر مجموعة</option>                                        
                                    @foreach ($groups_hr as $group)
                                        <option value="{{ $group->id }}" {{ old('poll_hr_group') == $group->id ? 'selected' : '' }}>{{ $group->title }}</option>                                        
                                    @endforeach
                                  </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                  <select class="form-control select2_select2" id="poll_hr_question" name="poll_hr_question" style="width: 100%;">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary submit" title="بحث">بحث</button>
                            </div>
                        </div>
                    </form>               
                </div>
            </div>
        </div>
    </div>
@endsection