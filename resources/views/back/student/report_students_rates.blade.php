<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="{{ url('back/assets/css/bill_dues/style_bill_dues.css') }}" media="all" />
</head>

<body style="direction: rtl;">
    <header class="clearfix" style="width: 100%;border: 2px solid #000;border-radius: 7px;">
      <div id="logo" style="width: 130px;height: 110px;">
        <img src="{{ url('back/images/settings/logo.png') }}">
      </div>

      <div id="company">
        <div style="padding: 2px 2px;">
          <img src="{{ url('back/images/settings/www.png') }}" style="width: 20px; height: 20px;margin: 0px 5px;" />
          <a href="https://edustage.net" target="_blank" style="position: absolute; bottom: 10px;">www.edustage.net</a>
        </div>
        <div style="padding: 2px 2px;">
          <img src="{{ url('back/images/settings/facebook (1).png') }}" style="width: 20px; height: 20px;margin: 0px 5px;" />
          <span style="position: absolute; bottom: 10px;">edustage.academy</span>
        </div>
        <div style="padding: 2px 2px;">
          <img src="{{ url('back/images/settings/youtube.png') }}" style="width: 20px; height: 20px;margin: 0px 5px;" />
          <span style="position: absolute; bottom: 10px;">EDUSTAGEACADEMY</span>
        </div>
        <div style="padding: 2px 2px;">
          <img src="{{ url('back/images/settings/whatsapp.png') }}" style="width: 20px; height: 20px;margin: 0px 5px;" />
          <span style="position: absolute; bottom: 10px;">01062808121 - 01015611494</span>
        </div>
      </div>
    </header>

    <div style="width: 100%;border: 2px solid #000;border-radius: 7px;margin-top: 20px;margin-bottom: 20px;padding: 0px 10px;">
      <h1 style="font-size: 16px;text-align: center;padding: 10px 0px;">
        تقرير التقييم الشهري لأولاد السيد:
        <span style="color: red; font-weight: bold;">{{ $parent_name->TheName0 }}</span>
      </h1>

      <div style="width: 50%;text-align: right;float: right;margin: 10px 0px 20px;">
        <div>
          رقم:
          <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $bill_num }}</span>
        </div>
        <div>
          بتاريخ:
          <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $bill_date }}</span>
        </div>
      </div>

      <div style="width: 50%;text-align: left;float: left;margin: 10px 0px 20px;">
        <div>
          شهر:
          <span style="font-weight: bold;margin: 0px 5px;">{{ $month }}</span>
        </div>
      </div>
    </div>


    @if (count($all_data) == 0)
      <main style="width: 100%;border: 2px solid #000;border-radius: 7px;padding-top: 20px;">
        <h3 style="text-align: center;padding: 30px;">لاتوجد بيانات لعرضها</h3>
      </main>
    @else
      <main style="width: 100%;border: 2px solid #000;border-radius: 7px;padding-top: 20px;">
        @foreach ($all_data as $item)  {{-- Start Foreach $st as $item --}}
          <div style="margin-bottom: 20px;">
              <div style="text-align: center;font-size: 16px;">
                اسم الطالب /
                <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $item->studentName }}</span>
              </div>

              <br />
              <br />

              <table style="text-align: center;font-size: 16px;">
                <thead>
                  <tr>
                    {{--  <th style="width: 10%;font-weight: bold;padding: 20px 3px;">التاريخ</th>  --}}
                    <th style="width: 20%;font-weight: bold;padding: 20px 3px;">الصف والمادة</th>
                    <th style="width: 20%;font-weight: bold;padding: 20px 3px;">اسم المدرس</th>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">الحضور</th>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">التفاعل</th>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">درجة الإختبار الشهري</th>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">الواجبات</th>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">الدرجة النهائية</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    {{--  <td style="text-align: center;">{{ $item->Eval_Date }}</td>  --}}
                    <td style="text-align: center;">{{ $item->TheFullName }}</td>
                    <td style="text-align: center;">{{ $item->teacherName }}</td>
                    <td style="text-align: center;">{{ $item->Eval_Att }}</td>
                    <td style="text-align: center;">{{ $item->Eval_Part }}</td>
                    <td style="text-align: center;">{{ $item->Eval_Eval }}</td>
                    <td style="text-align: center;">{{ $item->Eval_HW }}</td>
                    <td style="text-align: center;">{{ $item->Eval_Degree }}</td>
                  </tr>
                </tbody>
              </table>
          </div>

          <div style="padding: 5px 25px;font-size: 14px;">
            <span style="text-decoration: underline;font-weight: bold;">تعليق المدرس: </span>
            <span style="margin: 0px 15px;">{{ $item->Eval_TeacherComment }}</span>
          </div>

          <div style="padding: 5px 25px;font-size: 14px;">
            <span style="text-decoration: underline;font-weight: bold;">توجيهات المدرس: </span>
            <span style="margin: 0px 15px;">{{ $item->Eval_TeacherSugg }}</span>
          </div>

          <br />
          <p style="width: 100%;border: 4px solid#000;text-align: center;font-weight: bold;">
            ـــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
          </p>
          <br />
        @endforeach
        <br /><br /><br />
      </main>
      @endif


    <div style="color: #777777;width: 100%;height: 30px;position: absolute;bottom: 5;text-align: center;margin-right: 100px;">
      جميع الحقوق محفوظه لأكاديمية إيديوستيدج - حقوق الطبع والنشر لسنة © {{ date('Y') }}
    </div>
  {{-- </div> --}}

</body>
</html>
