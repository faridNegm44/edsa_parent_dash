@extends('back.layouts.app')

@section('title') تقيمات الطلاب @endsection


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

    $('input[type=date]').change(function () {
        $('.row_students_not_founded_res').css('display', 'none');
        $('.form2').css('display', 'none');
        $(".form2 .students option").remove();
        $('.form2 .from').val('');
        $('.form2 .to').val('');

    });



        $('.form1').submit(function(e){
            e.preventDefault();
            $(".form2 .students option").remove();
            $('.form2 .from').val('');
            $('.form2 .to').val('');

            let act = "{{ url('dashboard/students/get_students_to_rates') }}";
            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('.form1').serialize(),
                beforeSend: function(){
                    $('.row_students_not_founded_res').css('display', 'none');
                    $('.form2').css('display', 'none')
                },
                success: function (res) {
                    if(res.get_students.length === 0){
                        $('.row_students_not_founded_res').css('display', 'block');
                    }else{
                        $('.form2').css('display', 'block')

                        $('.form2 .month').val(res.month);

                        for(key in res.get_students){
                            $(".form2 .students").append(`
                                <option value="`+res.get_students[key].ID+`">`+res.get_students[key].TheName+`</option>
                            `);
                        }
                    }
                }
            });
        });

        $(".form2").submit(function(){
            swal("إنتظر قليلا: جاري تجهيز البيانات", {
                buttons: false,
                timer: 7000,
            });
        });
    </script>
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">تقيمات الطلاب</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تقيمات الطلاب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        تقيمات الطلاب
                    </h4>
                </div>
            </div>
            <div class="card-body">
               <form class="form1">
                   @csrf
                   <div class="row">
                       @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                            <div class="col-lg-4">
                                <label for="">اختر ولي أمر</label>
                                <div class="input-group mb-3"  style="width: 100%;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-users"></i></span>
                                    </div>
                                    <select name="parent" class="form-control select2_select2">
                                        @foreach ($parents as $item)
                                            <option value="{{ $item->ID }}">{{ $item->TheName0 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="errors" id="errors-name"></p>
                            </div>

                            <div class="col-lg-3">
                                <label for="from">من</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control from" name="from" value="{{ date('Y-01-01') }}" />
                                </div>
                                <p class="errors" id="errors-name"></p>
                            </div>

                            <div class="col-lg-3">
                                <label for="to">إلي</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="date" class="form-control to" name="to" value="{{ date('Y-m-d') }}" />
                                </div>
                                <p class="errors" id="errors-name"></p>
                            </div>

                            <div class="col-lg-2">
                                <label for="">عرض</label>
                                <div>
                                    <input type="submit" class="btn btn-primary" name="" value="عرض" />
                                </div>
                                <p class="errors" id="errors-name"></p>
                            </div>


                        @elseif(auth()->user()->user_status == 3)
                            <div class="col-lg-5">
                                <label for="month">اختر شهر</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <select class="form-control" name="month" id="month" required="">
                                        <option value="">اختر شهر</option>
                                        <option value="1"> ( 1 ) يناير</option>
                                        <option value="2"> ( 2 ) فبراير</option>
                                        <option value="3"> ( 3 ) مارس</option>
                                        <option value="4"> ( 4 ) أبريل</option>
                                        <option value="5"> ( 5 ) مايو</option>
                                        <option value="6"> ( 6 ) يونيو</option>
                                        <option value="7"> ( 7 ) يوليو</option>
                                        <option value="8"> ( 8 ) أغسطس</option> &nbsp;
                                        <option value="9"> ( 9 ) سبتمبر</option>
                                        <option value="10"> ( 10 ) أكتوبر<!--وoption--> &nbsp;
                                        </option><option value="11"> ( 11 ) نوفمبر</option>
                                        <option value="12"> ( 12 ) ديسمبر</option>
                                    </select>
                                </div>
                                <p class="errors" id="errors-name"></p>
                            </div>

                            <div class="col-lg-2">
                                <label for="">عرض</label>
                                <div>
                                    <input type="submit" class="btn btn-primary" name="" value="عرض" />
                                </div>
                                <p class="errors" id="errors-name"></p>
                            </div>

                        @endif
                    </div>
               </form>

               <div class="row row_students_not_founded_res text-center" style="display: none;">
                    <h3 style="color: gray;text-decoration: underline;padding: 30px 10px;">لاتوجد تقيمات لطلاب في هذة الفتره</h3>
               </div>

               <form class="form2" action="{{ url('dashboard/students/students_rates') }}" method="post" style="display: none;">
                   @csrf
                   <input type="hidden" class="month" value="" name="month">

                    <div class="row row_students">
                        <div class="col-sm-10">
                            <label for="">اختر طالب أو أكثر</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                                </div>
                                <select name="students[]" multiple class="form-control students">

                                </select>
                            </div>
                            <p class="errors" id="errors-students"></p>
                        </div>

                        <br />
                        <div class="col-lg-3" style="float:none;margin:auto;">
                            <br />
                            <div>
                                <input type="submit" class="btn btn-danger" name="" value="تقرير" />
                            </div>
                            <p class="errors" id="errors-name"></p>
                        </div>

                    </div>
               </form>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>

@endsection
