@extends('back.layouts.app')

@section('title') تقرير طلبات ولي أمر @endsection


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
        $(document).ready(function () {
            $(".select2_select2").select2();
        });
    </script>


    @include('back.user.delete');

@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">تقرير طلبات ولي أمر</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تقرير طلبات ولي أمر</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        تقرير طلبات ولي أمر
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="pd-30 pd-sm-40 bg-gray-100">
                    <form action="{{ url('dashboard/parent_problems/report/parent_post') }}" method="post">
                        @csrf
                        <div class="row row-xs">
                            <div class="col-md-5">
                                @if (auth()->user()->user_status == 3)
                                    <select name="parent_id" id="parent_id" class="form-control" required style="width: 100%;">
                                        <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                    </select>
                                @else
                                    <select name="parent_id" id="parent_id" class="form-control select2_select2" required style="width: 100%;">
                                        @foreach ($parents as $item)
                                            <option value="{{ $item->ID }}">{{ $item->TheName0 }} ( {{ ( $item->ThePhone1 ) }} )</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" id="from" name="from" type="datetime-local">
                            </div>
                            <div class="col-md-3 mg-t-10 mg-md-t-0">
                                <input class="form-control" id="to" name="to" type="datetime-local">
                            </div>
                            <div class="col-md-1 mg-t-10 mg-md-t-0">
                                <button class="btn btn-main-primary btn-block">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>



@endsection
