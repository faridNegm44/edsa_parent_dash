@extends('back.layouts.app')

@section('title') {{ $nameAr }} @endsection

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
        

    {{-- include polls_groups js --}}
    @include('back.polls_hr.polls_groups.main_js')
    
    {{-- include polls_questions js --}}
    @include('back.polls_hr.polls_questions.main_js')
    
    {{-- include answers_polls_questions js --}}
    @include('back.polls_hr.answers_polls_questions.main_js')

    <script>
        $(document).ready(function () {
            $(".select2_select2").select2({
                dropdownParent: $('#pollsAnswersToQuestionsModal'),
            });


            $("body").addClass('sidenav-toggled');


            // start when close modal
                $('.modal').on('hidden.bs.modal', function(){
                    $('textarea').val('');
                    $('select').val('');
                });
            // end when close modal
        });
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


    <div class="col-xl-12">
        <div class="card">
            <div class="panel panel-primary tabs-style-2">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1" style="background: #e9e9e9;">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs main-nav-line">
                            <li><a href="#polls_groups" class="nav-link active" data-toggle="tab">مجموعات الإستبيان</a></li>
                            <li><a href="#polls_questions" class="nav-link" data-toggle="tab">أسئلة الإستبيان</a></li>
                            <li><a href="#answers_to_polls_questions" class="nav-link" data-toggle="tab">إجابات الإستبيان</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body main-content-body-right border">
                    <div class="tab-content">



                        
                        {{-- ############################## polls_groups ############################  --}}
                        <div class="tab-pane active" id="polls_groups">
                            <div class="d-flex justify-content-between">
                                <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                                    مجموعات الإستبيان
                                </h4>
                                <div class="col-xs-6 d-flex">
                                    <a class="btn btn-primary btn-icon btn-sm text-white mr-2 add_modal" data-toggle="modal" data-target="#pollsGroupModal"><i class="fe fe-plus"></i></a>
                                </div>
                            </div>

                            <br>
                            <div class="table-responsive">
                                <table class="table text-md-nowrap table-striped table-bordered text-center" id="polls_groups_table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>عنوان المجموعة</th>
                                            <th>من</th>
                                            <th>الي</th>
                                            <th>تخصص المجموعة</th>
                                            <th>حالة المجموعة</th>
                                            <th>أكشن</th>
                                        </tr>
                                    </thead>                                    
                                </table>
                            </div>
                        </div>


                        {{-- ############################## polls_questions ############################  --}}
                        <div class="tab-pane" id="polls_questions">                            
                            <div class="d-flex justify-content-between">
                                <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                                    أسئلة الإستبيان
                                </h4>
                                <div class="col-xs-6 d-flex">
                                    <a class="btn btn-primary btn-icon btn-sm text-white mr-2 add_modal" data-toggle="modal" data-target="#pollsQuestionsModal"><i class="fe fe-plus"></i></a>
                                </div>
                            </div>
                            
                            <br>
                            <div class="table-responsive">
                                <table class="table text-md-nowrap table-striped table-bordered text-center" id="polls_questions_table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 25%">مجموعات الإستبيان</th>
                                            <th>نوع السؤال</th>
                                            <th style="width: 40%">السؤال</th>
                                            <th>نسبة مئوية %</th>
                                            <th>الحاله</th>
                                            <th>أكشن</th>
                                        </tr>
                                    </thead>                                    
                                </table>
                            </div>
                        </div>


                        {{-- ############################## answers_to_polls_questions ############################  --}}
                        <div class="tab-pane" id="answers_to_polls_questions">                            
                            <div class="d-flex justify-content-between">
                                <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                                    إجابات الإستبيان
                                </h4>
                                <div class="col-xs-6 d-flex">
                                    <a class="btn btn-primary btn-icon btn-sm text-white mr-2 add_modal" data-toggle="modal" data-target="#pollsAnswersToQuestionsModal"><i class="fe fe-plus"></i></a>
                                </div>
                            </div>

                            <br>
                            <div class="table-responsive">
                                <table class="table text-md-nowrap table-striped table-bordered text-center" id="answers_to_polls_questions_table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>المجموعة</th>
                                            <th style="width: 60%;">السؤال</th>
                                        </tr>
                                    </thead>                                    
                                </table>
                            </div>
                        </div>                      
                        
                    </div>
                </div>
            </div>
        </div><!-- bd -->
    </div>
    



    
    {{-- start pollsGroupModal --}}
        @include('back.polls_hr.polls_groups.modal')
    {{-- start pollsGroupModal --}}
    
    
    {{-- start pollsQuestionsModal --}}
        @include('back.polls_hr.polls_questions.modal')
    {{-- start pollsQuestionsModal --}}
    

    {{-- start pollsAnswersToQuestionsModal --}}
        @include('back.polls_hr.answers_polls_questions.modal')        
    {{-- start pollsAnswersToQuestionsModal --}}
    
    
    {{-- start answersModal --}}
        <div class="modal fade" id="answersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
    
                    <div class="modal-body text-center"></div>
                </div>
            </div>
        </div>            
    {{-- start answersModal --}}
@endsection