<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar" >
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('dashboard') }}">
            <img src="{{ url('back') }}/assets/img/brand/logo.png" class="main-logo logo-color1" alt="logo">
            <img src="{{ url('back') }}/assets/img/brand/logo2.png" class="main-logo logo-color2" alt="logo">
            <img src="{{ url('back') }}/assets/img/brand/logo3.png" class="main-logo logo-color3" alt="logo">
            <img src="{{ url('back') }}/assets/img/brand/logo4.png" class="main-logo logo-color4" alt="logo">
            <img src="{{ url('back') }}/assets/img/brand/logo5.png" class="main-logo logo-color5" alt="logo">
            <img src="{{ url('back') }}/assets/img/brand/logo6.png" class="main-logo logo-color6" alt="logo">
        </a>
            <a class="desktop-logo logo-dark active" href="{{ url('dashboard') }}">
                <img src="{{ url('back') }}/images/settings/small_logo.png" class="main-logo dark-theme" alt="logo" style="margin: 0px 20px;">
            </a>

        {{-- <a class="desktop-logo logo-dark active" href="{{ url('dashboard') }}" style="color: #fff;font-size: 20px;
        font-family: Archivo black;">
            EduStage
        </a> --}}
        <div class="app-sidebar__toggle" data-toggle="sidebar">
            <a class="open-toggle" href="#"><i class="header-icon fe fe-chevron-left"></i></a>
            <a class="close-toggle" href="#"><i class="header-icon fe fe-chevron-right"></i></a>
        </div>
    </div>
    @if (auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
        <div class="main-sidemenu sidebar-scroll">
            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('dashboard') }}"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-home icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الرئيسيه</span></a>
                </li>

                <hr />

                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                        <i class="fa fa-users icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                        <span class="side-menu__label">المستخدمين</span><i class="angle fe fe-chevron-left"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{ url('dashboard/users') }}">جميع المستخدمين</a></li>
                        </ul>
                    </li>


                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-user icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">أولياء الأمور</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/parents') }}">جميع أولياء الأمور</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-child icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الطلاب </span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/students') }}">جميع الطلاب</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-bell icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">إشعارات</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/noti_to_parent') }}">إشعارات لولي أمر أو أكثر</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/noti_to_class') }}">إشعارات لصف دراسي أو أكثر</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-money-bill-alt icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">المعاملات المالية </span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/parents_payments') }}">متحصلات من أولياء الأمور </a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/bill_dues') }}">كشف حساب </a></li>
                    </ul>
                </li>

                {{-- <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-list icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">رغبات الطلاب</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/students/desires') }}">الرغبات</a></li>
                    </ul>
                </li> --}}

                {{-- <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-list icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">عدد الحصص</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/count_of_shares') }}">عدد الحصص</a></li>
                    </ul>
                </li> --}}

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-question-circle icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">طلبات أولياء الأمور </span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/parent_problems') }}"> جميع الطلبات</a></li>

                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">تقارير الطلبات</span><i class="sub-angle fe fe-chevron-right"></i></a>
                            <ul class="sub-slide-menu open" style="display: block;">
                                <li><a class="sub-slide-item" href="{{ url('dashboard/parent_problems/report/between_dates') }}">تقرير طلبات بين تاريخين</a></li>
                                <li><a class="sub-slide-item" href="{{ url('dashboard/parent_problems/report/') }}">تقرير ولي أمر</a></li>
                                <li><a class="sub-slide-item" href="{{ url('dashboard/parent_problems/report/staff') }}">تقرير تقيم موظف</a></li>
                            </ul>
                        </li>

                        <li><a class="slide-item" href="{{ url('dashboard/problem_types') }}"> تصنيف الطلبات</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-poll icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الإستبيانات</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/polls_hr') }}">إستبيان الإدارة</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/polls_hr/users_answers') }}">إجابات إستبيان الإدارة</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/polls_teachers') }}"> إستبيان المدرسين</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/polls_teachers/users_answers') }}"> إجابات إستبيان المدرسين</a></li>
                    </ul>
                </li>

            </ul>
            {{-- <div class="app-sidefooter">
                <a class="side-menu__item" href="{{ url('dashboard/logout') }}"><span class="side-menu__label">تسجيل خروج</span><svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24"/></g><g><path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z"/></g></svg></a>
            </div> --}}
        </div>
    @elseif (auth()->user()->user_status == 3)
        <div class="main-sidemenu sidebar-scroll">
            <ul class="side-menu">
                <br />
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('dashboard') }}"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-home icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الرئيسيه</span></a>
                </li>

                <hr />

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('dashboard/parents/edit/'.auth()->user()->id) }}"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-user icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">بياناتي الشخصية</span></a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-child icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الطلاب </span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/students') }}">جميع الطلاب</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/students/attendance_and_absence_report_for_students') }}">تقرير الحضور والغياب للطلاب</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/students/students_rates') }}">تقيمات الطلاب</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-bell icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">إشعارات</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/noti_to_parent') }}">إشعارات</a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/noti_to_class') }}">إشعارات الصف الدراسي</a></li>
                    </ul>
                </li>

                {{-- <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('dashboard/students') }}"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-child icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الطلاب</span></a>
                </li>                --}}

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-money-bill-alt icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">المعاملات المالية </span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/parents_payments') }}">متحصلات من أولياء الأمور </a></li>
                        <li><a class="slide-item" href="{{ url('dashboard/bill_dues') }}">كشف حساب </a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-question-circle icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">طلبات ولي أمر</span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/parent_problems') }}"> جميع الطلبات</a></li>

                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-toggle="sub-slide" href="#"><span class="sub-side-menu__label">تقارير الطلبات</span><i class="sub-angle fe fe-chevron-right"></i></a>
                            <ul class="sub-slide-menu open" style="display: block;">
                                <li><a class="sub-slide-item" href="{{ url('dashboard/parent_problems/report/') }}">تقرير طلبات بين تاريخين</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            
            </ul>
            {{-- <div class="app-sidefooter">
                <a class="side-menu__item" href="{{ url('dashboard/logout') }}"><span class="side-menu__label">تسجيل خروج</span><svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24"/></g><g><path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z"/></g></svg></a>
            </div> --}}
        </div>
    @elseif (auth()->user()->user_status == 4)
        <div class="main-sidemenu sidebar-scroll">
            <ul class="side-menu">
                <br />
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('dashboard') }}"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fa fa-home icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">الرئيسيه</span></a>
                </li>

                <hr />

                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><div class="side-angle1"></div><div class="side-angle2"></div><div class="side-arrow"></div>
                    <i class="fas fa-question-circle icon_sidebar" style="margin: 0px 10px;font-size: 15px;"></i>
                    <span class="side-menu__label">طلبات أولياء الأمور </span><i class="angle fe fe-chevron-left"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ url('dashboard/parent_problems') }}"> جميع الطلبات</a></li>
                    </ul>
                </li>

            </ul>
            {{-- <div class="app-sidefooter">
                <a class="side-menu__item" href="{{ url('dashboard/logout') }}"><span class="side-menu__label">تسجيل خروج</span><svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24"/></g><g><path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z"/></g></svg></a>
            </div> --}}
        </div>
    @endif
</aside>
<!-- main-sidebar -->
