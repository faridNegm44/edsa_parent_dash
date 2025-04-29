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
                    <form action="{{ url('dashboard/polls_hr/reports_teachers/report_parent') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <select class="form-control select2_select2" id="parent_id" name="parent_id" style="width: 100%;">
                                    <option value="" disabled selected>إختر ولي أمر</option>                                        
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->ID }}" {{ old('parent_id') == $parent->ID ? 'selected' : '' }} >{{ $parent->TheName0 .' - '.$parent->ID }}</option>                                        
                                    @endforeach
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