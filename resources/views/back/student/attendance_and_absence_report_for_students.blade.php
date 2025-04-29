@extends('back.layouts.app')

@section('title') تقرير الحضور والغياب للطلاب @endsection


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
        $(document).ready(function(){
            $(".select2_select2").select2();
        });
        
        $("form").submit(function(){
            swal("إنتظر قليلا: جاري تجهيز البيانات", {
                buttons: false,
                timer: 7000,
            });

        });
    </script>

<script>
    $(document).ready(function(){
        $("#modaldemo9").modal('show');
    });
</script>
@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">تقرير الحضور والغياب للطلاب</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تقرير الحضور والغياب للطلاب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        تقرير الحضور والغياب للطلاب
                    </h4>                
                    <div class="col-xs-6 d-flex">
                        <a class="btn btn-warning btn-icon btn-sm text-white mr-2 modal-effect" data-effect="effect-sign" data-toggle="modal" href="#modaldemo9"><i class="fa fa-video"></i></a>
                    </div>    
                </div>
            </div>
            <div class="card-body">
               <form action="{{ url('dashboard/students/attendance_and_absence_report_for_students') }}" method="post">
                   @csrf
                   <div class="row">
                       @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
                            <div class="col-lg-4">
                                <label for="">إختر ولي أمر</label>
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
                        @elseif(auth()->user()->user_status == 3)
                            <input type="hidden" name="parent" value="{{ auth()->user()->id }}" />

                            <div class="col-lg-6">
                                <label for="">إختر طالب</label>
                                <div class="input-group mb-3"  style="width: 100%;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-users"></i></span>
                                    </div>
                                    <select name="students[]" class="form-control" multiple>
                                        @foreach ($get_students as $item)    
                                            <option value="{{$item->StudentID}}" style="padding: 10px;">{{ $item->StudentName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($errors->has('students'))
                                    <p class="errors" id="errors-name">{{ $errors->first('students') }}</p>
                                @endif
                            </div>

                            <div class="col-lg-6">
                                <label for="">إختر مجموعه</label>
                                <div class="input-group mb-3"  style="width: 100%;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                    </div>

                                    <select name="groups[]" class="form-control" multiple>
                                        @foreach ($get_students as $st)
                                            <optgroup label="{{ $st->StudentName }}" style="color: red;font-weight: bold;border: 1px solid red;border-radius: 2px;padding: 5px;text-align: center;"></optgroup>
                                        
                                            @foreach ($get_students_and_groups as $item)    
                                                @if ($st->StudentID === $item->StudentID)
                                                    <option value="{{$item->GroupID}}" style="padding: 10px;"> {{ $item->GroupName }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                @if($errors->has('groups'))
                                    <p class="errors" id="errors-name">{{ $errors->first('groups') }}</p>
                                @endif
                                
                            </div>
                        @endif
                        
                        
                        <div class="col-lg-6">
                            <label for="from">من</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control" name="from" value="{{ date('Y-01-01') }}" />
                            </div>
                            @if($errors->has('from'))
                                <p class="errors" id="errors-name">{{ $errors->first('from') }}</p>
                            @endif
                        </div>
                        
                        <div class="col-lg-6">
                            <label for="to">إلي</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control" name="to" value="{{ date('Y-m-d') }}" />
                            </div>
                            @if($errors->has('to'))
                                <p class="errors" id="errors-name">{{ $errors->first('to') }}</p>
                            @endif
                        </div>
                       
                        <div class="col-lg-1" style="float:none;margin:auto;margin-top: 20px;">
                            <div>
                                <input type="submit" class="btn btn-primary" name="" value="عرض" style="width: 70px;"/>
                            </div>
                        </div>
                   </div>
               </form>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>

    
    {{-- Modal Video How To Add New Student --}}
    <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title2" id="exampleModalLabel">فديو توضيحي لكيفية الاطلاع على تقارير حضور وغياب الطلاب</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="400px" src="https://www.youtube.com/embed/R-fHKEpWQzQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>

@endsection