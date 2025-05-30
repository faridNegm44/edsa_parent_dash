<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $nameAr }} - {{ date('Y-m-d h:i a') }}</title>
    
    <link rel="icon" href="{{ url('back') }}/images/settings/fiv.png" type="image/x-icon"/>
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600&display=swap" rel="stylesheet">

    <style>
        .panel-default {
            border: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="">
            <div class="invoice-title">
                <h4 class="text-center" style="font-weight: bold;">
                    {{ $nameAr }}
                </h4>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6 text-left">
                    <div style="padding-top: 10px;">
                        {{ date('Y-m-d') }} <span style="margin: 0px 10px;font-size: 16px;">{{ date('h:i a') }}</span>
                        
                        <div style="margin-left: 45px;">{{ auth()->user()->name }}</div>
                    </div>
                </div>
                <div class="col-xs-6 text-right">
                    <img src="{{ asset('back/images/settings/logo.png') }}" alt="" style="width: 80px;height: 70px;margin-top: -12px;margin-bottom: 10px;">
                </div>
            </div>
        </div>

        <div>
            <table class="table table-bordered table-striped text-center" style="font-size: 12px;">
                <thead class="">
                    <tr>
                        <th class="text-center">ع أسئلة المجحموعة</th>
                        <th class="text-center">ع من قاموا بالإستبيان</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $count_questions }}</td>
                        <td>{{ count($count_users_polling_teachers) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
            
        <div class="">
            <div class="">
                <div class="">
                    {{-- table table-condensed --}}
                    <table class="table table-bordered table-striped table-hover" style="font-size: 12px;"> 
                        <thead style="font-weight: bold;">
                            <tr>
                                <td class="text-center" style="font-weight: bold;width: 10%;"><strong>المستخدم</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 10%;"><strong>وقت التقييم</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 15%;"><strong>المدرس</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 25%;"><strong>السؤال</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 5%;"><strong>ق السؤال</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 5%;"><strong>ق الإجابة</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 10%;"><strong>الإجابة</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 10%;"><strong>ن ج من سؤال</strong></td>
                                {{-- <td class="text-center" style="font-weight: bold;width: 7.5%;"><strong>ن العميل</strong></td> --}}
                            </tr>
                        </thead>

                        <tbody style="font-size: 10px;">
                            @foreach ($get_polls_users_to_teachers as $key => $item)

                                @if ($item->question_type == 'radio')
                                    <tr>
                                        <td class="text-center">{{ $item->user_name }}</td>
                                        <td class="text-center" style="font-size: 8px;">{{ $item->created_at->format('Y-m-d h:i a') }}</td>
                                        @if ($key === 0)
                                            <td class="text-center" style="font-size: 15px;text-decoration: underline;">{{ $item->teacher_name }}</td>
                                        @elseif($key > 0 && $item->teacher_name !== $get_polls_users_to_teachers[$key - 1]->teacher_name)
                                            <td class="text-center" style="font-size: 15px;text-decoration: underline;">{{ $item->teacher_name }}</td>
                                        @else
                                            <td class="text-center">{{ $item->teacher_name }}</td>
                                        @endif
                                        <td class="text-center">{!! nl2br(json_decode($item->question_title)) !!}</td>
                                        <td class="text-center">{{ $item->question_percentage }}</td>
                                        <td class="text-center">{{ $item->answer_percentage }}</td>
                                        <td class="text-center" style="font-size: 9px;width: 20%;">{{ json_decode($item->answer_title) }}</td>
                                        <td class="text-center answer_percentage_from_question">
                                            {{ ($item->answer_percentage / $item->question_percentage) * 100 }} %
                                        </td>

                                        {{-- @php
                                            $sumTotal = DB::table('poll_users_to_teachers_only')->where('teacher_id', $item->teacher_id)->sum('total');
                                        @endphp
                                        @if ($key === 0) 
                                            <td class="text-center totalAnswersToParent" style="font-weight: bold;">
                                                {{ number_format($sumTotal, 1) }} %     
                                            </td>
                                        @elseif($key > 0 && $item->teacher_name !== $get_polls_users_to_teachers[$key - 1]->teacher_name)
                                            <td class="text-center totalAnswersToParent" style="font-weight: bold;">
                                                {{ number_format($sumTotal, 1) }} %     
                                            </td>
                                        @endif       --}}
                                    </tr>    
                                @else
                                    <tr>
                                        <td class="text-center">{{ $item->user_name }}</td>
                                        <td class="text-center" style="font-size: 8px;">{{ $item->created_at->format('Y-m-d h:i a') }}</td>
                                        @if ($key === 0)
                                            <td class="text-center" style="font-size: 15px;text-decoration: underline;">{{ $item->teacher_name }}</td>
                                        @elseif($key > 0 && $item->teacher_name !== $get_polls_users_to_teachers[$key - 1]->teacher_name)
                                            <td class="text-center" style="font-size: 15px;text-decoration: underline;">{{ $item->teacher_name }}</td>
                                        @else
                                            <td class="text-center">{{ $item->teacher_name }}</td>
                                        @endif
                                        <td class="text-center">{!! nl2br(json_decode($item->question_title)) !!}</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center" style="font-size: 9px;width: 20%;">{{ $item->answer }}</td>
                                        <td class="text-center answer_percentage_from_question">-</td>

                                        {{-- @php
                                            $sumTotal = DB::table('poll_users_to_teachers_only')->where('teacher_id', $item->teacher_id)->sum('total');
                                        @endphp
                                        @if ($key === 0) 
                                            <td class="text-center totalAnswersToParent" style="font-weight: bold;">
                                                {{ number_format($sumTotal, 1) }} %     
                                            </td>
                                        @elseif($key > 0 && $item->teacher_name !== $get_polls_users_to_teachers[$key - 1]->teacher_name)
                                            <td class="text-center totalAnswersToParent" style="font-weight: bold;">
                                                {{ number_format($sumTotal, 1) }} %     
                                            </td>
                                        @endif          --}}
                                    </tr>    
                                @endif
                                         
                            @endforeach

                            <tr>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>نسبة الإجابات</strong></td>
                                <td class="thick-line text-center" id="percentage" style="font-weight: bold;font-size: 12px;">
                                    {{ number_format($calcPercentageTotalAnswerFromTotalQuestion, 2) }} %
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>