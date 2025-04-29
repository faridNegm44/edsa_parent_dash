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
          فاتوره مقدمه إلي السيد ولي الأمر :
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
          من:
          <span style="font-weight: bold;margin: 0px 5px;">{{ $from }}</span>
        </div>
        <div>
          إلي:
          <span style="font-weight: bold;margin: 0px 5px;">{{ $to }}</span>
        </div>
      </div>
    </div>

    @if (count($st) == 0)
      <main style="width: 100%;border: 2px solid #000;border-radius: 7px;padding-top: 20px;">
        <h3 style="text-align: center;padding: 30px;">لاتوجد بيانات لعرضها</h3>
      </main>
    @else
      <main style="width: 100%;border: 2px solid #000;border-radius: 7px;padding-top: 20px;">
        @php
          $sumTotalFinally = 0;   // إجمالي مستحقات مطلوبه من تاريخ والي تاريخ
          $total_discount_between_two_date = 0;    // قيمه الخصومات عن الفتره المحدده
        @endphp
        @foreach ($st as $item2)
            <div style="margin-bottom: 20px;">
              <div style="text-align: center;font-size: 16px;">
                اسم الطالب /
                <span style="color: red; font-weight: bold;margin: 0px 5px;">{{ $item2->TheName }}</span>
              </div>

              <br />
              <br />

              <table style="text-align: center;font-size: 16px;">
                <thead>
                  <tr>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">الصف والماده</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">المجموعه</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">المدرس</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">ع الحصص</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">ق الحصه</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">خصم %</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">قيمه الخصم</th>
                    <th style="width: 10%;font-weight: bold;padding: 20px 3px;">ق الحصه بعد الخصم</th>
                    <th style="width: 15%;font-weight: bold;padding: 20px 3px;">الإجمالي</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $sumCountOfID = 0;
                    $sumTotal = 0;
                  @endphp

                  @foreach ($all_data as $item)
                    @if ($item2->StudentID === $item->TheStudentID)

                      @php($sumCountOfID += $item->CountOfID)
                      @php($sumTotal += ($item->TheGroupPrice - $item->TheS_DisAmount) * $item->CountOfID)
                      @php($total_discount_between_two_date += ($item->TheS_DisAmount * $item->CountOfID))

                      <tr>
                        <td style="text-align: center;">{{ $item->TheFullNameYearsMat }}</td>
                        <td style="text-align: center;">{{ $item->TheGroupName }}</td>
                        <td style="text-align: center;">{{ $item->TheTeacherName }}</td>
                        <td style="text-align: center;">{{ $item->CountOfID }}</td>
                        <td style="text-align: center;">{{ $item->TheGroupPrice }}</td>
                        <td style="text-align: center;">{{ $item->TheS_DisPre }}</td>
                        <td style="text-align: center;">{{ $item->TheS_DisAmount * $item->CountOfID }}</td>
                        <td style="text-align: center;">{{ $item->TheGroupPrice - $item->TheS_DisAmount }}</td>
                        <td style="text-align: center;">{{ ($item->TheGroupPrice - $item->TheS_DisAmount) * $item->CountOfID }}</td>
                      </tr>
                    @endif
                    @endforeach
                    <tr>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;color: red;font-weight: bold;">{{$sumCountOfID}}</td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;color: red;font-weight: bold;">{{ $sumTotal }}</td>
                      @php($sumTotalFinally += $sumTotal)
                    </tr>
                </tbody>
              </table>
              {{-- End Table --}}
            </div>   {{-- End Div Loop --}}
            <p style="width: 100%;border: 4px solid#000;text-align: center;font-weight: bold;">
              ـــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
            </p>
            <br />
          @endforeach
        <br />
        <br />
        <div id="notices" style="padding-bottom: 20px;width: 100%;">
          <table>
            <thead>
              <tr>
                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;width: 33.3%;">
                  إجمالي مستحقات مطلوبه
                  <br />
                  <span>من: {{ $from }}</span>
                  <br />
                  <span>إلي: {{ $to }}</span>
                </th>

                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;">
                  إجمالي مدفوعات الفترة المحددة
                </th>

                @if ($xPrevFinal == 0)

                @elseif ($xPrevFinal < 0)
                  <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;">
                    <span style="color: rgb(238, 198, 68);"> لكم عندنا</span>
                  </th>

                @elseif ($xPrevFinal > 0)
                  <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;">
                    <span style="color: rgb(238, 198, 68);"> لنا عندكم</span>
                  </th>
                @endif

                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;">
                  قيمة الخصومات عن الفترة المحددة
                </th>

                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;width: 33.3%;">
                  @if ((($sumTotalFinally-$payments_between_two_dates) + ($xPrevFinal)) > 0)
                    صافي المبلغ المطلوب سداده
                  @elseif ((($sumTotalFinally-$payments_between_two_dates) + ($xPrevFinal)) < 0)
                    رصيدكم لدى الأكاديمية
                  @elseif ((($sumTotalFinally-$payments_between_two_dates) + ($xPrevFinal)) == 0)
                    الرصيد متوازن
                  @endif
                </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td style="font-weight: bold;text-align: center;">{{ $sumTotalFinally }}</td>
                <td style="font-weight: bold;text-align: center;">{{ $payments_between_two_dates }}</td>
                @if ($xPrevFinal == 0)

                @elseif ($xPrevFinal < 0)
                  <td style="font-weight: bold;text-align: center;">{{ abs($xPrevFinal) }}</td>
                @elseif ($xPrevFinal > 0)
                  <td style="font-weight: bold;text-align: center;">{{ abs($xPrevFinal) }}</td>
                @endif
                <td style="font-weight: bold;text-align: center;">{{ $total_discount_between_two_date }}</td>
                <td style="font-weight: bold;text-align: center;">
                  @if (($sumTotalFinally+$previous_dues) > $parents_payments[0]->total_amount)


                    {{ abs(($sumTotalFinally-$payments_between_two_dates) + ($xPrevFinal)) }}


                  {{--  {{ ($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount }}  --}}




                  @elseif (($sumTotalFinally+$previous_dues) < $parents_payments[0]->total_amount)
                    {{ abs($parents_payments[0]->total_amount - ($sumTotalFinally+$previous_dues)) }}
                  @elseif (($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount == 0)
                    {{ abs(($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount) }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>




          {{-- <table>
            <thead>
              <tr>
                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;width: 33.3%;">
                  إجمالي مدفوعات
                </th>
                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;width: 33.3%;">
                  قيمه الخصومات عن الفتره المحدده
                </th>
                <th style="padding: 20px 3px;font-weight: bold;background: gray;color: #FFF;width: 33.3%;">
                  @if (($sumTotalFinally+$previous_dues) > $parents_payments[0]->total_amount)
                    صافي المبلغ المطلوب سداده
                  @elseif (($sumTotalFinally+$previous_dues) < $parents_payments[0]->total_amount)
                    رصيدكم لدى الأكاديمية
                  @elseif (($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount == 0)
                    الرصيد متوازن
                  @endif
                </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td style="font-weight: bold;text-align: center;">{{ $parents_payments[0]->total_amount }}</td>
                <td style="font-weight: bold;text-align: center;">{{ $total_discount_between_two_date }}</td>
                <td style="font-weight: bold;text-align: center;">
                  @if (($sumTotalFinally+$previous_dues) > $parents_payments[0]->total_amount)
                    {{ ($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount }}
                  @elseif (($sumTotalFinally+$previous_dues) < $parents_payments[0]->total_amount)
                    {{ $parents_payments[0]->total_amount - ($sumTotalFinally+$previous_dues) }}
                  @elseif (($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount == 0)
                    {{ ($sumTotalFinally+$previous_dues) - $parents_payments[0]->total_amount }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table> --}}
        </div>
      </main> {{-- End Main --}}
    @endif


    <div style="color: #777777;width: 100%;height: 30px;position: absolute;bottom: 5;text-align: center;margin-right: 100px;">
      جميع الحقوق محفوظه لأكاديمية إيديوستيدج - حقوق الطبع والنشر لسنة © {{ date('Y') }}
    </div>
  {{-- </div> --}}

</body>
</html>
