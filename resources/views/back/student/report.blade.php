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
        تقرير التفقد الخاص بأبناء ولي الأمر السيد:
        <span style="color: red; font-weight: bold;">{{ $parent_name->TheName0 }}</span>
      </h1>

      <div style="width: 50%;text-align: right;float: right;margin: 10px 0px 20px;">
        {{-- <div>
          رقم: 
          <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $bill_num }}</span>
        </div> --}}
        <div>
          بتاريخ: 
          <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $bill_date }}</span>
        </div>
      </div>
      
      <div style="width: 50%;text-align: left;float: left;margin: 10px 0px 20px;">
        <div>
          من: 
          <span style="font-weight: bold;margin: 0px 5px;">{{ $from }}</span>
        </div>
        <div>
          إلي: 
          <span style="font-weight: bold;margin: 0px 5px;">{{ $to }}</span>
        </div>
      </div>
    </div>

      @if (count($all_data) === 0)
        <main style="width: 100%;border: 2px solid #000;border-radius: 7px;padding-top: 20px;"> 
          <h3 style="text-align: center;padding: 30px;">لاتوجد بيانات لعرضها</h3>
        </main>
      @else
        <main style="width: 100%;border: 2px solid #000;border-radius: 7px;padding-top: 20px;"> 
          @foreach ($st as $item2)  {{-- Start Foreach $st as $item2 --}}
            <div style="margin-bottom: 20px;">
                <div style="text-align: center;font-size: 16px;"> 
                  اسم الطالب / 
                  <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $item2->TheName }}</span>
                </div> 
                
                <br />
                <br />

                <table style="text-align: center;font-size: 16px;">             {{-- Start Table Students And Groups  --}}
                  <thead>
                    <tr>
                      <th style="width: 20%;font-weight: bold;padding: 10px 3px;">#</th>
                      <th style="width: 20%;font-weight: bold;padding: 15px 3px;">الصف والماده</th>
                      <th style="width: 15%;font-weight: bold;padding: 20px 3px;">المجموعه</th>
                      <th style="width: 20%;font-weight: bold;padding: 15px 3px;">المدرس</th>
                      <th style="width: 10%;font-weight: bold;padding: 10px 3px;">رقم الحصة</th>
                      <th style="width: 20%;font-weight: bold;padding: 15px 3px;">تاريخ الحصة</th>
                      <th style="width: 15%;font-weight: bold;padding: 15px 3px;">الحالة</th>
                    </tr>
                  </thead>
                  <tbody>

                    @php($countAllLessons = 0)     
                    @php($countLessons = 0)                 
                    @php($countAbsence = 0)
                    @php($countAbsence2 = 0)

                    @php($studentsNum = 0)
                      @foreach ($all_data as $item)
                        @if ($item2->StudentID === $item->StudentID)
                          @php($studentsNum++)
                          @php($countAllLessons++)

                          @if ($item->TheStatus === 'حاضر')
                            @php($countLessons++)
                          @elseif($item->TheStatus === 'غائب/مدفوع')
                            @php($countAbsence++)
                          @else
                            @php($countAbsence2++)
                          @endif
                          <tr>
                            <td style="text-align: center;">{{ $studentsNum }}</td>
                            <td style="text-align: center;">{{ $item->TheFullName }}</td>
                            <td style="text-align: center;">{{ $item->GroupName }}</td>
                            <td style="text-align: center;">{{ $item->TeacherName }}</td>
                            <td style="text-align: center;">{{ $item->ClassNumber }}</td>
                            <td style="text-align: center;">{{ $item->TheDate }}</td>
                            <td style="text-align: center;">{{ $item->TheStatus }}</td>
                          </tr>
                        @endif  
                      @endforeach  
                  </tbody>
                </table>                                                        {{-- End Table Students And Groups  --}}

                <br><br><br>
                
                <table style="text-align: center;">                             {{-- Start Table Totals  --}}
                  <thead>
                    <tr>
                      <th style="font-weight: bold;padding: 20px 3px;background: gray;color: #FFF;">إجمالي عدد الحصص</th>
                      <th style="font-weight: bold;padding: 20px 3px;background: gray;color: #FFF;">الحضور</th>
                      <th style="font-weight: bold;padding: 20px 3px;background: gray;color: #FFF;">مدفوع / غائب</th>
                      <th style="font-weight: bold;padding: 20px 3px;background: gray;color: #FFF;">الغياب</th>
                    </tr>
                  </thead>
                  <tbody> 
                      <tr>
                        <td style="text-align: center;">{{$countAllLessons}} حصة</td>
                        <td style="text-align: center;">
                          <span style="margin: 0px 20px;">{{ $countLessons }} حصة</span>
                          - 
                          @if (!$countLessons)
                              0
                          @else
                            <span style="margin: 0px 10px;font-weight: bold;">{{ round((($countLessons / $countAllLessons) * 100) , 2) }} %</span>
                          @endif
                        </td>
                        <td style="text-align: center;">
                          <span style="margin: 0px 20px;">{{ $countAbsence}} حصة</span>
                          - 
                          @if (!$countAbsence)
                              0
                          @else
                          <span style="margin: 0px 10px;font-weight: bold;">{{ round((($countAbsence / $countAllLessons) * 100) , 2) }} %</span>
                          @endif
                        </td>
                        <td style="text-align: center;">
                          <span style="margin: 0px 20px;">{{ $countAbsence2 }} حصة</span>
                          - 
                          @if (!$countAbsence2)
                              0
                          @else
                            <span style="margin: 0px 10px;font-weight: bold;">{{ round((($countAbsence2 / $countAllLessons) * 100) , 2) }} %</span> 
                          @endif
                        </td>
                      </tr>
                  </tbody>
                </table>                                                         {{-- End Table Totals  --}}
            </div>
            
            <p style="width: 100%;border: 4px solid#000;text-align: center;font-weight: bold;">
              ـــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
            </p>
            <br />  
          @endforeach {{-- End Foreach $st as $item2 --}}
        </main>
      @endif
    {{-- @endif --}}
    
    
    <div style="color: #777777;width: 100%;height: 30px;position: absolute;bottom: 5;text-align: center;margin-right: 100px;">
      جميع الحقوق محفوظه لأكاديمية إيديوستيدج - حقوق الطبع والنشر لسنة © {{ date('Y') }}
    </div>
  {{-- </div> --}}

</body>
</html>