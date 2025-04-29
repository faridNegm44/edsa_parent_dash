@extends('back.layouts.app')

@section('title') كشف حساب @endsection


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
            // notif({
            //     msg: "",
            //     type: "success",
            // });

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
            <h4 class="content-title mb-2">كشف حساب</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">كشف حساب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        كشف حساب
                    </h4>                    
                </div>
            </div>
            <div class="card-body">
               <form action="{{ url('dashboard/bill_dues/show/1') }}" method="post">
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
                        @elseif(auth()->user()->user_status == 3)
                            <input type="hidden" name="parent" readonly class="form-control" value="{{ $parent->ID }}" />
                        @endif
                        
                        
                        <div class="col-lg-3">
                            <label for="from">من</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control" name="from" value="{{ date('Y-01-01') }}" />
                            </div>
                            <p class="errors" id="errors-name"></p>
                        </div>
                        
                        <div class="col-lg-3">
                            <label for="to">إلي</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control" name="to" value="{{ date('Y-m-d') }}" />
                            </div>
                            <p class="errors" id="errors-name"></p>
                        </div>
                       
                        <div class="col-lg-1">
                            <label for="">عرض</label>
                            <div>
                                <input type="submit" class="btn btn-primary" name="" value="عرض" />
                            </div>
                            <p class="errors" id="errors-name"></p>
                        </div>
                   </div>
               </form>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>

@endsection