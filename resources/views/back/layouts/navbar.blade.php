<!-- main-header -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left">
            <div class="responsive-logo">
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo.png" class="logo-1 logo-color1" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo2.png" class="logo-1 logo-color2" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo3.png" class="logo-1 logo-color3" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo4.png" class="logo-1 logo-color4" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo5.png" class="logo-1 logo-color5" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo6.png" class="logo-1 logo-color6" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/logo-white.png" class="dark-logo-1" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/images/settings/small_logo.png" style="width: 180px;" class="logo-2 logo-color1" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/favicon2.png" class="logo-2 logo-color2" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/favicon3.png" class="logo-2 logo-color3" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/favicon4.png" class="logo-2 logo-color4" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/favicon5.png" class="logo-2 logo-color5" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/favicon6.png" class="logo-2 logo-color6" alt="logo"></a>
                <a href="{{ url('dashboard') }}"><img src="{{ url('back') }}/assets/img/brand/favicon-white.png" class="dark-logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle d-md-none" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
        </div>
        <div class="main-header-right">
            <div class="nav nav-item  navbar-nav-right ml-auto">
                {{-- <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <i class="fe fe-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="main-header-search ml-0 d-sm-none d-none d-lg-block">
                    <input class="form-control" id="search-input"  placeholder="Search for anything..." type="text"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
                </div> --}}

                @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2 || auth()->user()->user_status == 4)
                    <div class="dropdown nav-item main-header-notification">
                        <a class="new nav-link" href="#">
                            <i class="fe fe-bell" style="color: rgb(235, 36, 46);font-weight: bold;"></i>
                            <div data-toggle="tooltip" data-placement="bottom" title="{{ DB::table('parent_problems')->orderBy('id', 'DESC')->where('readed', 0)->whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59')])->count() }} إشعارات غير مقرؤه" style="position: relative;top: -45px;right: -15px;background: rgb(235, 36, 46);color: #fff;border-radius: 50%;text-align: center;font-size: 12px;width: 23px;height: 23px;line-height: 20px;">
                                {{ DB::table('parent_problems')->orderBy('id', 'DESC')->where('readed', 0)->whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59')])->count() }}
                            </div>
                        </a>
                        <div class="dropdown-menu shadow">
                            <div class="menu-header-content text-left d-flex" style="background: rgb(235, 36, 46);color: #fff;">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0 text-center">
                                        إشعارات تخص طلبات أولياء الأمور
                                    </h6>
                                </div>
                            </div>
                            <div class="main-notification-list Notification-scroll ps" style="overflow: auto;">
                                @foreach (App\Models\ParentProblems::orderBy('id', 'DESC')->where('readed', 0)->whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59')])->get() as $item)
                                    <a href="{{ url('dashboard/parent_problems/edit/'.$item->id) }}" target="_blank" class="d-flex p-3 border-bottom" href="#">
                                        <div class="ml-3">
                                            <p>
                                                {{ $item->problem_type_relation['name'] }}
                                            </p>

                                            <p class="notification-label mb-1" target="_blank">
                                                {!! $item->problem !!}
                                            </p>

                                            <div class="notification-subtext" style="font-weight: bold;">
                                                <p>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                    <span style="margin: 0px 3px;">{{  \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</span>
                                                </p>

                                                <p>
                                                    {{-- @php
                                                        $users = App\Models\ParentProblems::join('users', 'parent_problems.parent_id', '=', 'users.id')
                                                        ->get();
                                                    @endphp
                                                    @foreach ($users as $user) --}}
                                                        <p>
                                                            {{ $item->parent['name']  }}
                                                        </p>
                                                    {{-- @endforeach --}}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                <div class="dropdown-footer">
                                    <a href="{{ url('dashboard/parent_problems') }}">جميع الإشعارات</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown nav-item main-header-notification" style="margin: 0px -10px;">
                        <a class="new nav-link" href="#">
                            <i class="fa fa-comment" style="color: rgb(29, 187, 63);font-weight: bold;"></i>
                        </a>
                        <div class="dropdown-menu shadow">
                            <div class="menu-header-content text-left d-flex" style="background: rgb(29, 187, 63);color: #fff;">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0 text-center">
                                        تعليقات تخص طلبات أولياء الأمور
                                    </h6>
                                </div>
                            </div>
                            <div class="main-notification-list Notification-scroll ps" style="overflow: auto;">

                                    @php
                                        $comments = App\Models\ProblemComments::orderBy('id', 'DESC')
                                                    ->whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59')])
                                                    ->take(50)
                                                    ->get();
                                    @endphp

                                {{-- check if auth user id == user commnent id not show his comment --}}
                                @foreach ($comments as $item)
                                    @if (auth()->user()->id != $item->commented_by)
                                        <div class="d-flex p-3 border-bottom" href="#">
                                            <div class="ml-3">

                                                <a href="{{ url('dashboard/parent_problems/edit/'.$item->problem_id) }}" class="notification-label mb-1" target="_blank">
                                                    تم التعليق من قبل
                                                    <span style="color: red;font-weight: bold;">{{ $item->user['name'] }}</span>
                                                    علي طلب
                                                    <br />
                                                    {!! $item->problem['problem'] !!}

                                                    <p style="color: blue;font-weight: bold;">التعليق: {{ $item->edited_comment != null ? $item->edited_comment : $item->comment }}</p>
                                                </a>

                                                <div class="notification-subtext" style="font-weight: bold;">
                                                    <p>
                                                        {{  \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                        <span style="margin: 0px 3px;">{{  \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="dropdown-footer">
                                    <a href="{{ url('dashboard/parent_problems') }}">جميع الإشعارات</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @elseif (auth()->user()->user_status == 3)
                    <div class="dropdown nav-item main-header-notification noti_to_parent">
                        <a class="new nav-link" href="#">
                            <i class="fe fe-bell" style="color: rgb(71, 98, 248);font-weight: bold;"></i>
                            <div data-toggle="tooltip" data-placement="bottom" title="{{ DB::table('noti_to_parents')->where('parent_id', auth()->user()->id)->where('readed', 2)->count() }} إشعارات غير مقرؤه" style="position: relative;top: -45px;right: -15px;background: rgb(71, 98, 248);color: #fff;border-radius: 50%;text-align: center;font-size: 12px;width: 23px;height: 23px;line-height: 20px;">
                                {{ DB::table('noti_to_parents')->where('parent_id', auth()->user()->id)->where('readed', 2)->count() }}
                            </div>
                        </a>
                        <div class="dropdown-menu shadow">
                            <div class="menu-header-content text-left d-flex" style="background: rgb(71, 98, 248);color: #fff;">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0 text-center">
                                        إشعارات تخص ( {{ auth()->user()->name }} )
                                    </h6>
                                </div>
                            </div>
                            <div class="main-notification-list Notification-scroll ps" style="overflow: auto;">
                                @foreach (DB::table('noti_to_parents')->orderBy('id', 'DESC')->take(5)->where('parent_id', auth()->user()->id)->where('status', 1)->get() as $item)
                                    <div class="d-flex p-3 border-bottom" href="#">
                                        <div class="ml-3">
                                            <h5 class="notification-label mb-1" style="font-weight: bold;font-size: 15px;text-decoration: underline;color: rgb(194, 10, 10);" data-toggle="tooltip" title="{{ $item->title }}" data-placement="right">
                                                {!! \Illuminate\Support\Str::limit($item->title, 30, '....') !!}
                                            </h5>
                                            <p data-toggle="tooltip" title="{{ $item->description }}" data-placement="right">
                                                {!! \Illuminate\Support\Str::limit($item->description, 70, '....') !!}
                                            </p>
                                            <div class="notification-subtext" style="color: rgb(194, 10, 10);font-weight: bold;">
                                                {{  \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                <p>{{  \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="dropdown-footer">
                                    <a href="{{ url('dashboard/noti_to_parent') }}">جميع الإشعارات</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown nav-item main-header-notification noti_to_class">
                        <a class="new nav-link" href="#">
                            <i class="fe fe-bell" style="color: rgb(223, 61, 20);font-weight: bold;"></i>
                            <div data-toggle="tooltip" data-placement="bottom" title="{{ DB::table('noti_to_classes')
                            ->join('tbl_students_years_mat', 'tbl_students_years_mat.YearID', 'noti_to_classes.class_id')
                            ->join('tbl_years_mat', 'tbl_years_mat.ID', 'noti_to_classes.class_id')
                            ->join('users', 'users.id', 'noti_to_classes.sender')
                            ->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                            ->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')
                            ->where('tbl_parents.ID', auth()->user()->id)
                            ->where('readed', 2)
                            ->select('title', 'description', 'sender', 'noti_to_classes.created_at', 'noti_to_classes.id', 'class_id', 'TheFullName', 'name', 'readed')
                            ->count() }} إشعارات غير مقرؤه" style="position: relative;top: -45px;right: -15px;background:rgb(223, 61, 20);color: #fff;border-radius: 50%;text-align: center;font-size: 12px;width: 23px;height: 23px;line-height: 20px;">
                                {{ DB::table('noti_to_classes')
                                    ->join('tbl_students_years_mat', 'tbl_students_years_mat.YearID', 'noti_to_classes.class_id')
                                    ->join('tbl_years_mat', 'tbl_years_mat.ID', 'noti_to_classes.class_id')
                                    ->join('users', 'users.id', 'noti_to_classes.sender')
                                    ->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')
                                    ->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')
                                    ->where('tbl_parents.ID', auth()->user()->id)
                                    ->where('readed', 2)
                                    ->select('title', 'description', 'sender', 'noti_to_classes.created_at', 'noti_to_classes.id', 'class_id', 'TheFullName', 'name', 'readed')
                                    ->count()
                                }}
                            </div>
                        </a>
                        <div class="dropdown-menu shadow">
                            <div class="menu-header-content text-left d-flex" style="background: rgb(223, 61, 20);color: #fff;">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0 text-center">
                                        إشعارات تخص المواد الدراسية الذي ينتمي إليها أولادك
                                    </h6>
                                </div>
                            </div>
                            <div class="main-notification-list Notification-scroll ps" style="overflow: auto;">
                                @foreach (DB::table('noti_to_classes')->join('tbl_students_years_mat', 'tbl_students_years_mat.YearID', 'noti_to_classes.class_id')->join('tbl_years_mat', 'tbl_years_mat.ID', 'noti_to_classes.class_id')->join('users', 'users.id', 'noti_to_classes.sender')->join('tbl_students', 'tbl_students.ID', 'tbl_students_years_mat.StudentID')->join('tbl_parents', 'tbl_students.ParentID', 'tbl_parents.ID')->where('tbl_parents.ID', auth()->user()->id)->select('title', 'description', 'sender', 'noti_to_classes.created_at', 'noti_to_classes.id', 'class_id', 'TheFullName', 'name', 'readed')->orderBy('id', 'DESC')->take(5)->get() as $item)
                                    <div class="d-flex p-3 border-bottom" href="#">
                                        <div class="ml-3">
                                            <h5 class="notification-label mb-1" style="font-weight: bold;font-size: 15px;text-decoration: underline;color: rgb(194, 10, 10);" data-toggle="tooltip" title="{{ $item->title }}" data-placement="right">
                                                {!! \Illuminate\Support\Str::limit($item->title, 30, '....') !!}
                                            </h5>
                                            <p data-toggle="tooltip" title="{{ $item->description }}" data-placement="right">
                                                {!! \Illuminate\Support\Str::limit($item->description, 70, '....') !!}
                                            </p>
                                            <div class="notification-subtext" style="color: rgb(40, 100, 212);font-weight: bold;">
                                                <p>{{  $item->TheFullName }}</p>
                                            </div>
                                            <div class="notification-subtext" style="color: rgb(194, 10, 10);font-weight: bold;">
                                                {{  \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                <p>{{  \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="dropdown-footer">
                                    <a href="{{ url('dashboard/noti_to_class') }}">جميع الإشعارات</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown nav-item main-header-notification" style="margin: 0px -10px;">
                        <a class="new nav-link" href="#">
                            <i class="fa fa-comment" style="color: rgb(29, 187, 63);font-weight: bold;"></i>
                        </a>
                        <div class="dropdown-menu shadow">
                            <div class="menu-header-content text-left d-flex" style="background: rgb(29, 187, 63);color: #fff;">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0 text-center">
                                        تعليقات تخص ( {{ auth()->user()->name }} )
                                    </h6>
                                </div>
                            </div>
                            <div class="main-notification-list Notification-scroll ps" style="overflow: auto;">
                                    @php
                                        $comments = App\Models\ProblemComments::orderBy('id', 'DESC')
                                                    ->whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59')])
                                                    ->take(50)
                                                    ->get();
                                    @endphp

                                @foreach ($comments as $item)
                                    @if (auth()->user()->id != $item->commented_by)
                                        <div class="d-flex p-3 border-bottom" href="#">
                                            <div class="ml-3">

                                                <a href="{{ url('dashboard/parent_problems/edit/'.$item->problem_id) }}" class="notification-label mb-1" target="_blank">
                                                    تم التعليق من قبل
                                                    <span style="color: red;font-weight: bold;">{{ $item->user['name'] }}</span>
                                                    علي طلب
                                                    <br />
                                                    {!! $item->problem['problem'] !!}


                                                    <p style="color: blue;font-weight: bold;">التعليق: {{ $item->edited_comment != null ? $item->edited_comment : $item->comment }}</p>
                                                </a>

                                                <div class="notification-subtext" style="font-weight: bold;">
                                                    <p>
                                                        {{  \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                        <span style="margin: 0px 3px;">{{  \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="dropdown-footer">
                                    <a href="{{ url('dashboard/parent_problems') }}">جميع الإشعارات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="#"><img alt="" src="{{ url('back') }}/images/settings/user.png">
                        <div class="p-text d-none">
                            <span class="p-name font-weight-bold">{{ Auth::user()->name }}</span>
                            <small class="p-sub-text">{{ Auth::user()->email }}</small>
                        </div>
                    </a>
                    <div class="dropdown-menu shadow">
                        <div class="main-header-profile header-img">
                            <div class="main-img-user"><img src="{{ url('back') }}/images/settings/user.png"></div>
                            <h6>{{ Auth::user()->name }}</h6><span>{{ Auth::user()->email }}</span>
                        </div>
                        {{-- <a class="dropdown-item" href="#"><i class="far fa-user"></i> My Profile</a>
                        <a class="dropdown-item" href="#"><i class="far fa-edit"></i> Edit Profile</a>
                        <a class="dropdown-item" href="#"><i class="far fa-clock"></i> Activity Logs</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-sliders-h"></i> Account Settings</a> --}}
                        <a class="dropdown-item" href="{{ url('dashboard/logout') }}"><i class="fas fa-sign-out-alt"></i>تسجيل خروج</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
