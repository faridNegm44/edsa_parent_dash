@extends('back.layouts.app')

@section('title') الرئيسية @endsection

@section('header')
    <style>
        td{
            vertical-align: middle !important;
        }
    </style>
   
@endsection

@section('footer')    
    <script>
        $(document).ready(function(){
            $("#modaldemo9").modal('show');
            $("#modaldemo10").modal('show');
        });


        // close div poll
        const closeButton = document.querySelector('.close-button');
        const myDiv = document.querySelector('.poll_div');

        closeButton.addEventListener('click', () => {
            const confirmDialog = confirm('هل تريد غلق الإستبيان في الوقت الحالي والإستكمال في وقت لاحق؟');
            if (confirmDialog) {
                localStorage.setItem('edu_poll_hr', JSON.stringify({
                    closed: true,
                    closedTime: Date.now(),
                }));
                
                myDiv.remove();
            }else{
                return false;
            }
        });


        const showSurveyAgain = () => {
            const edu_poll_hr = JSON.parse(localStorage.getItem('edu_poll_hr'));            
            // const closedTime = edu_poll_hr.closedTime;
            const now = Date.now();
            const differenceInHours = Math.floor((now - closedTime) / (1000 * 60 * 60));

            if (edu_poll_hr.closed == true && differenceInHours >= 1) {
                document.querySelector('.poll_div').style.display = 'block';
            }else{
                document.querySelector('.poll_div').style.display = 'none';
            }
        };
        showSurveyAgain();
    </script>
@endsection

@section('content')
    {{-- Modal Video How To Add Parent Payment --}}
    <div class="modal fade" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000000;">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title2" id="exampleModalLabel">فديو توضيحي للداشبورد</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <iframe width="100%" height="400px" src="https://www.youtube.com/embed/13CMtnNVtKs" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
    </div>

    <!-- breadcrumb -->
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
    <!-- breadcrumb -->

    @if (auth()->user()->user_status == 3)
        <div class="row row-sm">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body pd-20">
                        <div class="card shadow mg-b-20 rounded-10 text-white account-background">
                            <div class="card-body pd-b-10 text-center" style="background: crimson;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">عدد الطلاب</p>
                                <h2 class="tx-40">
                                    {{ \App\Models\Student::where('ParentID', auth()->user()->id)->count() }}
                                </h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('dashboard/students') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
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
                            <div class="card-body pd-b-10 text-center" style="background: goldenrod;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">تقرير الحضور / الغياب</p>
                                <h2 class="tx-40">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('dashboard/students/attendance_and_absence_report_for_students') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
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
                            <div class="card-body pd-b-10 text-center" style="background-color: darkcyan;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">تقرير التقيمات الشهرية</p>
                                <h2 class="tx-40">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('dashboard/students/students_rates') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
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
                            <div class="card-body pd-b-10 text-center" style="background: #40aa44;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">
                                    @if ($previous_dues > $parents_payments[0]->total_amount)
                                        صافي المبلغ المطلوب سداده
                                    @elseif ($previous_dues < $parents_payments[0]->total_amount)
                                        رصيدكم المتبقي لدينا
                                    @elseif ($previous_dues = $parents_payments[0]->total_amount)
                                        الرصيد متوازن
                                    @endif
                                </p>
                                <h2 class="tx-40">
                                    @if ($previous_dues > $parents_payments[0]->total_amount)
                                        {{ $previous_dues - $parents_payments[0]->total_amount }}
                                    @elseif ($previous_dues < $parents_payments[0]->total_amount)
                                        {{ $parents_payments[0]->total_amount - $previous_dues }}
                                    @elseif ($previous_dues = $parents_payments[0]->total_amount)
                                        0
                                    @endif
                                </h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('dashboard/bill_dues') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
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
                            <div class="card-body pd-b-10 text-center" style="background: rgb(155, 87, 138);border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">إضافة فاتورة</p>
                                <h2 class="tx-40">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('dashboard/parents_payments') }}" style="color: #fff;text-decoration: underline;">تفاصيل </a>
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
                            <div class="card-body pd-b-10 text-center" style="background: gray;border-radius: 7px;">
                                <p class="mg-b-0" style="margin-bottom: 7px;">إرسال طلب</p>
                                <h2 class="tx-40">
                                    <i class="fa fa-arrow-circle-down"></i>
                                </h2>
                                <p class="mg-b-0 mg-t-20">
                                    <a href="{{ url('dashboard/parent_problems') }}" style="color: #fff;text-decoration: underline;">تفاصيل</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
