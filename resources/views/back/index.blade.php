@extends('back.layouts.app')

@section('title') الرئيسية @endsection

@section('header')
    {{-- <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ url('back') }}/poll_hr/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ url('back') }}/poll_hr/assets/css/style.css">
    <link href="{{ url('back') }}/assets/plugins/fontawesome-free/css/all.min.css" rel="stylesheet">

    <style>
        td{
            vertical-align: middle !important;
        }

        .h3_teacher_name{
            background: #7c4545;
            width: 35%;
            padding: 13px;
            border-radius: 50px;
            margin: 20px auto 10px;
            color: #fff;
        }

        @media only screen and (max-width: 600px){
            .h3_teacher_name{
                width: 80%;
            }
        }


        /* start students tabs css */
            .students_tabs{
                padding: 10px 15px;
            }
            .students_tabs .student_name{
                font-weight: bold;
                font-size: 24px;
                text-decoration: underline;
                border: 2px solid #cccccc;
                border-radius: 3px;
                width: 200px;
                margin: auto;
                padding: 6px;
                margin-bottom: 20px;
            }
            .students_tabs .card .card_right p{
                font-size: 14px;
            }
            .students_tabs .card .card_right b{
                font-size: 17px;
            }
            .students_tabs .card .hr_cards{
                border: 1px solid #ccc;
                margin-top: 30px;
            }
        /* end students tabs css */

    </style>
@endsection

@section('footer')
    <!--  chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


    <script>
        $(document).ready(function(){
            $("#modaldemo9").modal('show');
            $("#modaldemo10").modal('show');
        });
    </script>

    {{-- close div poll --}}
    <script>
        const closeButton = document.querySelector('.close-button');

        closeButton.addEventListener('click', () => {
            const confirmDialog = confirm('هل تريد غلق الإستبيان في الوقت الحالي والإستكمال في وقت لاحق؟');
            if (confirmDialog) {
                localStorage.setItem('edu_poll_hr', JSON.stringify({
                    closed: true,
                    closedTime: Date.now(),
                    userId: {{ auth()->user()->id }}
                }));

                $(".poll_div_modal").modal('hide');
            }else{
                return false;
            }
        });


        const edu_poll_hr = JSON.parse(localStorage.getItem('edu_poll_hr'));
        const now = Date.now();
        const differenceInHours = Math.floor((now - edu_poll_hr.closedTime) / (1000 * 60 * 60));



        if(edu_poll_hr.userId == {{ auth()->user()->id }} ){
            if (edu_poll_hr.closed == true && differenceInHours < 1) {
                $(".poll_div_modal").remove();
            }
        }

    </script>
{{-- close div poll --}}


    {{-- send poll hr --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#sendPollBtn', function(e){
                e.preventDefault();

                const textareaCheck = document.querySelectorAll('textarea');
                let url = "{{ url('dashboard/polls_hr/poll_users_hr_teachers') }}";

                if(textareaCheck.length > 0){   // check if founded textarea or not
                    for(const textarea of textareaCheck){   // loop on textarea
                        if(textarea.value.trim() == ""){   // check if textarea value not == null
                            textarea.style.border = '1px solid red';
                        }else{
                            textarea.style.border = '';
                            $("#sendPollBtn").css('display', 'none');

                            $.ajax({
                                type: "post",
                                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                                url: url,
                                data: $("form").serialize(),
                                success: function (res) {
                                    if (res.success) {
                                        localStorage.removeItem('edu_poll_hr');
                                        $(".poll_div_modal").remove();
                                        alert(res.message);

                                        window.location.href = "{{ url('dashboard') }}";
                                    }
                                }
                            });
                        }
                    }
                }else{
                    $.ajax({
                        type: "post",
                        headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        url: url,
                        data: $("form").serialize(),
                        success: function (res) {
                            if (res.success) {
                                localStorage.removeItem('edu_poll_hr');
                                $(".poll_div_modal").remove();
                                alert(res.message);

                                window.location.href = "{{ url('dashboard') }}";
                            }
                        }
                    });
                }
            });
        });
    </script>
    {{-- send poll hr --}}



    {{-- send poll teachers --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#sendPollBtnTeachers', function(e){
                e.preventDefault();

                const textareaCheck = document.querySelectorAll('textarea');
                let url = "{{ url('dashboard/polls_hr/poll_users_teachers') }}";

                $("#sendPollBtnTeachers").css('display', 'none');

                $.ajax({
                    type: "post",
                    headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    url: url,
                    data: $("form").serialize(),
                    success: function (res) {
                        if (res.success) {
                            localStorage.removeItem('edu_poll_hr');
                            $(".poll_div_modal").remove();

                            alert(res.message);
                            window.location.href = "{{ url('dashboard') }}";
                        }
                    }
                });
            });
        });
    </script>
    {{-- send poll teachers --}}



    {{-- start charts to parents --}}
    @if (auth()->user()->user_status == 3)
    <script>
        const students = @json(AllStudentsChart()['students']);
        const studentsDegree = @json(AllStudentsChart()['studentsDegree']);
        const degreesDetails = @json(AllStudentsChart()['degreesDetails']);
    
        $.each(students, function(indexStudents, valueStudents) {    // start each to students
            $.each(studentsDegree, function(indexStudentsDegree, valueStudentsDegree) {    // start each to StudentsDegree
                if (valueStudents.ID == valueStudentsDegree.ID) {
                    if (valueStudentsDegree.percentage > 0) {
                        // تأكد من وجود العنصر في الـ DOM قبل محاولة الوصول إليه
                        const chartId = `chart${valueStudentsDegree.ID}_${valueStudentsDegree.Eval_Month}`;
                        const chartElement = document.getElementById(chartId);
    
                        if (chartElement) {
                            // الحصول على المواد الخاصة بالطالب الحالي في الشهر الحالي
                            const studentDegrees = degreesDetails.filter(function(degree) {
                                return degree.ID === valueStudents.ID && degree.Eval_Month === valueStudentsDegree.Eval_Month;
                            });
    
                            var ctx1 = chartElement.getContext('2d');
                            var myChart1 = new Chart(ctx1, {
                                type: 'bar',
                                data: {
                                    labels: studentDegrees.map(function(value) {
                                        return value.TheMat; // أسماء المواد
                                    }),
                                    datasets: [{
                                        label: '',
                                        data: studentDegrees.map(function(value) {
                                            return value.Eval_Degree; // قيم التقييم
                                        }),
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.6)',
                                            'rgba(54, 162, 235, 0.6)',
                                            'rgba(255, 206, 86, 0.6)',
                                            'rgba(30, 159, 150, 0.6)',
                                            'rgba(30, 60, 120, 0.6)',
                                            'rgba(153, 102, 0, 0.6)',
                                            'rgba(30, 159, 150, 0.6)',
                                            'rgba(255, 99, 100, 0.6)',
                                            'rgba(50, 162, 235, 0.6)',
                                            'rgba(255, 206, 90, 0.6)',
                                            'rgba(75, 192, 170, 0.6)',
                                            'rgba(50, 50, 50, 0.6)',
                                            'rgba(255, 159, 120, 0.6)',
                                            'rgba(75, 192, 192, 0.6)',
                                            'rgba(153, 102, 90, 0.6)',
                                            'rgba(160, 99, 60, 0.6)',
                                            'rgba(100, 162, 235, 0.6)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true, // جعل الرسم البياني متجاوبًا
                                    maintainAspectRatio: false, // عدم الحفاظ على النسبة الثابتة
                                    plugins: {
                                        datalabels: {
                                            color: "#000", // لون النص
                                            anchor: "end", // محاذاة النص في نهاية العمود
                                            align: "center", // محاذاة النص أعلى العمود
                                            rotation: "-90",
                                            padding: "20px 0",
                                            formatter: function(value, context) {
                                                return value+" %"; // عرض قيمة Eval_Degree
                                            },
                                            font: {
                                                weight: "bold", // الخط عريض
                                                size: 11 // حجم الخط
                                            }
                                        }
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                                min: 0,
                                                max: 100,
                                                stepSize: 20,
                                                fontColor: "#000", // لون الخطوط على المحور Y
                                                fontWeight: "bold", // الخط عريض
                                                fontSize: 12 // حجم الخط
                                            },
                                            gridLines: {
                                                display: true // إظهار خطوط الشبكة
                                            }
                                        }],
                                        xAxes: [{
                                            ticks: {
                                                fontColor: "#000", // لون الخطوط على المحور X
                                                fontWeight: "bold", // الخط عريض
                                                fontSize: 12, // حجم الخط
                                                autoSkip: false, // منع تخطي التسميات
                                                maxRotation: 90, // تدوير التسميات بزاوية 90 درجة
                                                minRotation: 90 // تدوير التسميات بزاوية 90 درجة
                                            },
                                            gridLines: {
                                                display: false // إخفاء خطوط الشبكة
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false // إخفاء وسيلة الإيضاح
                                    }
                                },
                                plugins: [ChartDataLabels] // تفعيل مكتبة datalabels
                            });
                        }
                    }
                }
            });    // end each to StudentsDegree
        });    // end each to students
    </script>
    
    @endif
    {{-- end charts to parents --}}


@endsection

@section('content')

    {{-- start script pollings and && check if auth()->user()->user_status == 3 --}}
        @if (auth()->user()->user_status == 3)
            {{-- modalPollingToHr --}}
            @include('back.modalsPollings.modalPollingToHr')

            {{-- modalPollingToTeachers --}}
            @include('back.modalsPollings.modalPollingToTeachers')
        @endif
    {{-- end script pollings and && check if auth()->user()->user_status == 3 --}}





    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h4 class="content-title mb-2">مرحبًا ( {{ Auth::user()->name }} )
                <a class="btn btn-warning btn-icon btn-sm text-white mr-2 modal-effect" data-effect="effect-sign" data-toggle="modal" href="#modaldemo10" style="display: inline;padding: 10px 10px 5px;border-radius: 10px;"><i class="fa fa-video"></i></a>
            </h4>
            @if (auth()->user()->email_verified_at == null && auth()->user()->user_status === 3 )
                <p style="color: red;font-weight: bold;font-size: 15px;">تاكد من الذهاب لبريدك الإلكتروني لإتمام عمليه التحقق منه </p>
            @endif

        </div>
    </div>

    @if (auth()->user()->user_status == 3)




    <div class="panel panel-primary tabs-style-2 card" style="padding: 15px 0;">
        <b class="text-center" style="margin-bottom: 20px;font-size: 13px;">
            "هذا الرسم البياني يوضح تقييمات أولادك في مختلف المواد الدراسية. يهدف إلى تقديم نظرة شاملة عن أدائهم الأكاديمي ومساعدتك في تحديد المواد التي تحتاج إلى تحسين."
        </b>

        <div class=" tab-menu-heading">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    {{--<li><a href="#mainTab" class="nav-link active" data-toggle="tab">جميع chart</a></li>--}}
                    @foreach (AllStudentsChart()['students'] as $student)
                        <li><a href="#tab{{ $student->ID }}" class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab">{{ $student->TheName }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                {{--<div class="tab-pane active" id="mainTab">
                    
                    <div class="row">
                        @foreach (Months() as $month)
                            <div class="col-md-3 col-12">
                                <b class="text-center">{{ $month[0] }}</b>
                                <canvas id="chart{{ $month[1] }}" height="200"></canvas>
                            </div>
                        @endforeach
                    </div>

                </div>--}}

                @foreach (AllStudentsChart()['students'] as $student)   {{-- start foreach AllStudentsChart()['students'] --}} 
                    <div class="tab-pane students_tabs {{ $loop->first ? 'active' : '' }}" id="tab{{ $student->ID }}">
                        <h3 class="text-center student_name">
                            {{ $student->TheName }}
                        </h3>
                        <div class="row">   {{-- start row --}}

                            @foreach (AllStudentsChart()['studentsDegree'] as $studentDegree)   {{-- start foreach AllStudentsChart()['studentsDegree'] --}}
                            
                                @if ($student->ID == $studentDegree->ID)    {{-- start if $student->ID == $studentDegree->ID --}}

                                    @if ($studentDegree->percentage > 0)    {{-- start if $studentDegree->percentage > 0 --}}
                                        <div class="card col-lg-6 col-12">
                                            <h4 class="card-title text-center">
                                                تقيم شهر 
                                                <b>{{ $studentDegree->Eval_Month }}</b>
                                            </h4>
                                            <div class="row">
                                                <div class="col-lg-3 card_right">                                                
                                                    <p>النسبة: <b >{{ number_format($studentDegree->percentage, 2) }} %</b></p>
                                                    <p>مواد الطالب: <b>{{ $studentDegree->num_subjects }}</b></p>
                                                    {{--<p>مواد قيمت: <b>{{ $studentDegree->num_subjects }}</b></p>--}}
                                                </div>
                                                
                                                <div class="col-lg-9 card_left">
                                                    <canvas id="chart{{ $studentDegree->ID }}_{{ $studentDegree->Eval_Month }}" style="min-height: 190px;max-height: 190px;"></canvas>
                                                </div>
                                            </div>                                    
                                            <hr class="hr_cards"/>
                                        </div>
                                    @else
                                        <div class="card col-12">
                                            <h5 class="text-center text-danger" style="margin-top: 20px;">لاتوجد تقيمات لهذا الطالب في الوقت الحالي</h5>
                                        </div>
                                    @endif    {{-- end if $studentDegree->percentage > 0 --}}

                                @endif  {{-- end if $student->ID == $studentDegree->ID --}}

                            @endforeach     {{-- end foreach AllStudentsChart()['studentsDegree'] --}}
                        </div>   {{-- end row --}}
                    </div>
                @endforeach     {{-- end foreach AllStudentsChart()['students'] --}}
            </div>
        </div>
    </div>
    


    {{-- start include cards --}}
        {{--@include('back.home_page_components.cards')--}}
    {{-- end include cards --}}


    <br>
    <hr>
    <br>
    
    
    <h5 style="text-decoration: underline;">جدول مختصر لرغبات الطلاب</h5>
    <br>
    <div class="table-responsive card">
        <table class="table table-striped table-bordered text-center card-body pd-20">
            <thead style="background: #333;color: #fff;">
                <tr>
                    <th>كود الطالب</th>
                    <th>إسم الطالب</th>
                    <th>رغبات الطالب</th>
                </tr>

            <tbody>
                @if (count($get_students) == 0)
                <tr>
                    <td></td>
                    <td style="font-size: 17px;">لاتوجد رغبات</td>
                    <td></td>
                </tr>
                @else
                    @foreach ($get_students as $item)
                        <tr>
                            <td>{{ $item->StudentID }}</td>
                            <td>{{ $item->TheName }}</td>
                            <td>
                                <ol style="text-align: center;">
                                    @foreach ($get_students2p as $item2p)
                                        @if ($item->StudentID === $item2p->StudentID)
                                            <li style="padding: 10px;">{{ $item2p->TheFullName }}</li>
                                        @endif
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>

    @elseif(auth()->user()->user_status == 1 || auth()->user()->user_status == 2)
        <div class="row row-sm">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: crimson;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">عدد الطلاب</p>
                                <h2 class="tx-40">3</h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: darkorange;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">إجمالي المدفوعات</p>
                                <h2 class="tx-40">1000,5</h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: darkcyan;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">إجمالي المستحقات</p>
                                <h2 class="tx-40">76,9</h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: darkolivegreen;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">Your Account Balance</p>
                                <h2 class="tx-40">$34,56,908</h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: darkorchid;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">Your Account Balance</p>
                                <h2 class="tx-40">$34,56,908</h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: grey;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">Your Account Balance</p>
                                <h2 class="tx-40">$34,56,908</h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if ($noti_to_classes_unreaded != 0 || $noti_to_parents_unreaded != 0)
        <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
            <div class="modal-dialog modal-lg" role="document" style="margin-top: 100px;">
                <div class="modal-content" style="background: #5066e0;color: #fff;">
                    <div class="modal-body">
                        <div class="text-center" style="margin: 30px auto 30px;">
                            <h4 class="content-title mb-2">مرحبًا ( {{ Auth::user()->name }} ) </h4>
                        </div>

                        <hr>
                        @if ($noti_to_parents_unreaded != 0)
                            <div class="text-center" style="font-size: 17px;height: 80px;line-height: 80px;">
                                <span>لديك عدد</span>
                                <span style="background: #000;padding: 1px 10px 4px;border-radius: 3px;color: #fff;font-size: 18px;margin: 0px 4px;">{{ $noti_to_parents_unreaded }}</span>
                                <span>إشعار غير مقروء تخصك</span>
                            </div>
                        @endif

                        @if ($noti_to_classes_unreaded != 0)
                            <div class="text-center" style="font-size: 17px;height: 80px;line-height: 80px;overflow: auto;">
                                <span>لديك عدد</span>
                                <span style="background: #000;padding: 1px 10px 4px;border-radius: 3px;color: #fff;font-size: 18px;margin: 0px 4px;">{{ $noti_to_classes_unreaded }}</span>
                                <span>إشعار غير مقروء تخص المواد الدراسية الذي ينتمي إليها أولادك</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
