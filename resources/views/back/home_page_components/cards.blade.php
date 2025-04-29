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
                            كشف حساب
                            {{--  @if ($previous_dues > $parents_payments)
                                صافي المبلغ المطلوب سداده
                            @elseif ($previous_dues < $parents_payments)
                                رصيدكم المتبقي لدينا
                            @elseif ($previous_dues = $parents_payments)
                                الرصيد متوازن
                            @endif  --}}
                        </p>
                        <h2 class="tx-30">
                            <a href="{{ url('dashboard/bill_dues') }}" style="color: blue;text-decoration: underline;">كشف حساب</a>
                            {{--  @if ($previous_dues > $parents_payments)
                                {{ $previous_dues - $parents_payments }}
                            @elseif ($previous_dues < $parents_payments)
                                {{ $parents_payments - $previous_dues }}
                            @elseif ($previous_dues = $parents_payments)
                                0
                            @endif  --}}
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