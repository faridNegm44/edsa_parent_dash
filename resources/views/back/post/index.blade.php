@extends('back.layouts.app')

@section('title') @lang('app.Posts') @endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ url('back') }}/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('back') }}/assets/css/file-upload-with-preview.min.css" rel="stylesheet">

    
    {{-- <link href="{{ url('back') }}//assets/plugins/select2/css/select2.min.css" rel="stylesheet"> --}}

@endsection

@section('footer')
    <script src="{{ url('back') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('back') }}/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
    {{-- <script src="{{ url('back') }}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('back') }}/assets/js/select2.js"></script> --}}
    <script src="{{ url('back') }}/assets/js/modal.js"></script>
    <script src="{{ url('back') }}/assets/js/file-upload-with-preview.min.js"></script>

    <script>
       
        $('#example2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('dashboard/posts/datatable_posts') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'address', name: 'address'},
                {data: 'description', name: 'description'},
                {data: 'tags', name: 'tags'},
                {data: 'image', name: 'image'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'},
            ],
            order: [[0, "DESC"]]
        });

    </script>

    <script>
        $(document).on('click', '.bt_modal', function (e) {
            e.preventDefault();
            let act = $(this).attr('act');
            
            $('#modaldemo8').modal();
            $('#modal_content').load(act);
        });
    </script>

    <script>
        $(document).ready(function (){
            // $('.select2').select2();

            @include('back.post.view');
            @include('back.tag.delete');
        });
    </script>

<script src="https://releases.transloadit.com/uppy/v1.27.0/uppy.min.js"></script>
    
@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">@lang('app.posts')</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">@lang('app.Dashboard')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('app.posts')</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0 pd-t-25">
                <div class="d-flex justify-content-between">
                    <h4 class="col-xs-6 card-title mg-b-0" style="padding-top: 10px;">
                        @lang('app.All posts')
                    </h4>
                    <div class="col-xs-6 d-flex">
                        <a class="btn btn-primary btn-icon btn-sm text-white mr-2 modal-effect bt_modal" act="{{ url('dashboard/posts/get_add_form') }}" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"><i class="fe fe-plus"></i></a>
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-striped" id="example2">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">@lang('app.Id')</th>
                                <th class="wd-15p border-bottom-0">@lang('app.Address')</th>
                                <th class="wd-15p border-bottom-0">@lang('app.Description')</th>
                                <th class="wd-15p border-bottom-0">@lang('app.Tags')</th>
                                <th class="wd-15p border-bottom-0">@lang('app.Image')</th>
                                <th class="wd-15p border-bottom-0">@lang('app.Created At')</th>
                                <th class="wd-15p border-bottom-0">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>

    
    {{-- Add Or Edit Modal --}}
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-xl" role="document">
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