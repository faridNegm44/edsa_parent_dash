<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تقرير استبيان لولي أمر يخص جروبات الإدارة: {{ $parent }} - {{ date('Y-m-d h:i a') }}</title>
    
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
                    تقرير استبيان لولي أمر يخص جروبات الإدارة
                    <br>
                    <br>
                    <p>ولي أمر: {{ $parent }}</p>
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
                        <th class="text-center">نسبة إجابات ولي الأمر</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>% {{ number_format($sumTotal, 2) }}</td>
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
                                <td class="text-center" style="font-weight: bold;width: 10%;"><strong>المجموعة</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 10%;"><strong>وقت التقييم</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 25%;"><strong>السؤال</strong></td>
                                <td class="text-center" style="font-weight: bold;width: 25%;"><strong>الإجابة</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>ق السؤال</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>ق الإجابة</strong></td>
                                <td class="text-center" style="font-weight: bold;"><strong>ن الإجابة من السؤال</strong></td>
                            </tr>
                        </thead>

                        <tbody style="font-size: 10px;">
                            @foreach ($get_polls_users_to_hr as $key => $item)
                                @if ($item->question_type != 'radio')
                                    <tr>
                                        <td class="text-center">{{ $item->group_name }}</td>
                                        <td class="text-center" style="font-size: 8px;">{{ $item->created_at->format('Y-m-d h:i a') }}</td>
                                        <td class="text-center">{!! nl2br(json_decode($item->question_title)) !!}</td>
                                        <td class="text-center">{{ $item->answer }}</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    </tr>           
                                @else
                                    <tr>
                                        <td class="text-center">{{ $item->group_name }}</td>
                                        <td class="text-center" style="font-size: 8px;">{{ $item->created_at->format('Y-m-d h:i a') }}</td>
                                        <td class="text-center">{!! nl2br(json_decode($item->question_title)) !!}</td>
                                        <td class="text-center">{{ json_decode($item->answer_title) }}</td>
                                        <td class="text-center">{{ number_format($item->question_percentage, 2) }}</td>
                                        <td class="text-center">{{ number_format($item->answer_percentage, 2) }}</td>
                                        <td class="text-center answer_percentage_from_question">   
                                            @if ($item->question_percentage != 0)
                                                % {{ number_format( ($item->answer_percentage / $item->question_percentage) * 100 , 2) }}                                                
                                            @endif
                                        </td>
                                    </tr>           
                                @endif                 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>