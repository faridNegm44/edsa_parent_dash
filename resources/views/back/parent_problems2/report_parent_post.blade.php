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
        tr td:nth-child(2){
            width: 35%;
        }
    </style>
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
                    @if (count($find) != null)
                        <button class="btn btn-primary print_button" style="display: block;margin: 10px auto;">
                            طباعه
                            <i class="fa fa-print" style="font-size: 18px;margin: 0px 5px;"></i>
                        </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="panal_body" style="padding: 40px 20px;">
                    <div style="position: relative;">
                        <span class="card-title mg-b-0" style="padding-top: 10px;">
                            تقرير طلبات ولي أمر ( {{ $first->name }} )
                        <br>
                        <br>
                        <span style="color: red;font-weight: bold;margin: 0px 10px;text-decoration: underline;">من: {{ $from == null ? ' ' : Carbon\Carbon::parse($from)->format('Y-m-d h:i') }}</span>
                        <span style="color: red;font-weight: bold;margin: 0px 10px;text-decoration: underline;">إلي: {{ $to == null ? ' ' :  Carbon\Carbon::parse($to)->format('Y-m-d h:i') }}</span>
                        </span>

                        <span style="position: absolute;left: 10px;top: -25px">
                            <img src="{{ url('back/images/settings/logo.png') }}" style="width: 100px;height: 100px;">
                        </span>
                    </div>

                    <br>
                    @if (count($find) != null)
                        <table class="table table-bordered text-center ">
                            <thead style="background: #ccc;">
                                <tr>
                                    <th>#</th>
                                    <th>الطلب</th>
                                    <th>إسناد إلي</th>
                                    <th>تاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($find as $key => $item)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>
                                            <ul>
                                                <li><span style="font-weight: bold;font-size: 12px;">تصنيف الطلب :</span><br /> {{ $item->problem_type }}</li>
                                                <hr>
                                                <li><span style="font-weight: bold;font-size: 12px;">مضمون الطلب :</span><br /> {!! $item->problem !!}</li>
                                            </ul>
                                        </td>
                                        {{-- <td>
                                            <ul>
                                                <li>
                                                    <span style="font-weight: bold;font-size: 12px;">تقيم الطلب :</span><br />
                                                    {{ $item->problem_rating }}
                                                </li>
                                                <hr>
                                                <li>
                                                    <span style="font-weight: bold;font-size: 12px;">حالة الطلب :</span><br />
                                                    {{ $item->problem_status }}
                                                </li>
                                            </ul>
                                        </td> --}}
                                        <td>
                                            <ul>
                                                <li>
                                                    <span style="font-weight: bold;font-size: 12px;">إسناد إلي :</span>
                                                    <span style="font-size: 15px;"> {{ $item->staff_id == null ? '' : $item->staff['name'] }}</span>
                                                </li>
                                                @if (auth()->user()->user_status != 3)
                                                    <hr>
                                                    <li>
                                                        <span style="font-weight: bold;font-size: 12px;">تاريخ الإسناد :</span>
                                                        <span style="font-size: 15px;"> {{ $item->staff_id == null ? '' : Carbon\Carbon::parse($item->date_reference)->format('Y-m-d') }}</span>
                                                        <br />
                                                        <span style="font-size: 15px;"> {{ $item->staff_id == null ? '' : Carbon\Carbon::parse($item->date_reference)->format('h:i') }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                        {{-- <td>
                                            {{ $item->staff_rating }}
                                        </td> --}}
                                        <td>
                                            <ul>
                                                <li>
                                                    <span style="font-weight: bold;font-size: 12px;">تاريخ إرسال الطلب :</span>
                                                    <span style="font-size: 15px;"> {{ $item->created_at == null ? ' ' : Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</span>
                                                    <br />
                                                    <span style="font-size: 15px;"> {{ $item->created_at == null ? ' ' : Carbon\Carbon::parse($item->created_at)->format('h:i') }}</span>
                                                </li>
                                                <hr>
                                                <li>
                                                    <span style="font-weight: bold;font-size: 12px;">تاريخ غلق الطلب :</span>
                                                    <span style="font-size: 15px;"> {{ $item->ended_at == null ? ' ' : Carbon\Carbon::parse($item->ended_at)->format('Y-m-d') }}</span>
                                                    <br/>
                                                    <span style="font-size: 15px;"> {{ $item->ended_at == null ? ' ' : Carbon\Carbon::parse($item->ended_at)->format('h:i') }}</span>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h5 class="mg-b-0" style="padding-top: 10px;text-align: center;">
                            لايوجد بيانات لعرضها
                        </h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')

    <script src="{{ url('back') }}/assets/js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

    <script>
        $(document).ready(function () {
            $("body").addClass('sidenav-toggled');
        });
    </script>

    <script>
        $(".print_button").click(function(){
            $('.panal_body').printArea();
        });
    </script>

@endsection

