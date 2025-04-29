<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quizo HTML Template - V.2</title>

   <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600&display=swap" rel="stylesheet">
   <link href="{{ url('back') }}/assets/plugins/icons/icons.css" rel="stylesheet">
   <link rel="stylesheet" href="{{ url('back') }}/poll_hr/assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="{{ url('back') }}/poll_hr/assets/css/animate.min.css">
   <link rel="stylesheet" href="{{ url('back') }}/poll_hr/assets/css/style.css">


   <style>
        *{
            font-family: Cairo;
        }
        .poll_div {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10000000;
            background-color: #ffffff;
            overflow: auto;
        }

        .close-button{
            position: fixed;
            width: 45px;
            height: 45px;
            border-radius: 0px;
            left: 0px;
        }

        .heading_section{
            background: #444;
            padding: 16px;
            color: #fff;
            width: 30%;
            margin: auto;
            border-radius: 30px;
        }

        @media only screen and (max-width: 767px) {
            .heading_section {
                width: 70%;
            }
        }

    </style>

</head>
<body>
   
    <div class="poll_div">
        <button class="close-button btn btn-danger">
            <i class="fa fa-times"></i>
        </button>

        <div class="wrapper pt-5">
            <div class="container-fluid" style="display: none;">
               <div class="row text-center">
                  <div class="col step_progress d-flex d-none d-sm-block">
                        @foreach ($questions as $question)
                            <span class="step bg-white rounded-pill {{ $loop->iteration === 1 ? 'active' : '' }}" style="margin: 5px;"></span>
                        @endforeach
                  </div>
               </div>
            </div>


            <div class="container"> 
                {{-- <h4 class="text-center heading_section">( تقييم الإدارة )</h4> --}}
               <form class="multisteps_form position-relative" id="wizard" style="margin-top: -40px;">
                @csrf
                    <input type="hidden" name="group_id" value="{{ $polls_groups[0]->id }}">
                    
                    @foreach ($questions as $question)
                        <div class="multisteps_form_panel" >

                            <span class="question_number text-uppercase d-flex justify-content-center align-items-center" style="color: #d50808;text-decoration: u7derline;font-size: 17px;">
                                @if ($loop->iteration === 1)
                                    الأسئلة {{ $loop->iteration }}/{{ $questions->count() }}                                    
                                @else
                                    السؤال {{ $loop->iteration }}                                    
                                @endif
                            </span>
                            <h4 class="text-center">
                                {{ $question->question }}
                            </h4>
                            
                            <div class="form_items justify-content-center">                            
                                @if (count($question->answers) > 0)
                                    <ul class="ps-0">
                                        @foreach ($question->answers as $answer)     
                                    
                                            <div class="step_1 rounded-pill bg-white text-center animate__animated animate__fadeInRight animate_50ms">

                                                <input type="radio" {{ $loop->iteration == 1 ? 'checked' : '' }} id="opt_{{ $question->id.'_'.$answer->answer }}" name="{{ $question->id }}" value="{{ $answer->answer }}" />

                                                <label for="opt_{{ $question->id.'_'.$answer->answer }}">
                                                    {{ $answer->answer }}
                                                </label>
                                            </div>                                        
                                        @endforeach
                                    </ul>
                                @else
                                    <textarea class="form-control" id="" rows="5" style="height: 200px;margin-top: 26px;border-radius: 26px;padding: 10px;" name="{{ $question->id }}"></textarea>
                                @endif                                
                            </div>
                        </div>   
                        
                        @if ($loop->last != true)                            
                            <hr />
                        @endif
                    @endforeach

                    <div class="form_btn d-flex justify-content-center align-items-center ms-5 mt-5">
                        <button type="button" class="f_btn rounded-pill border-0" id="sendPollBtn">
                            إرسال التقييم <i class='fas fa-chevron-left' style='position: relative;top: 3px;right: 7px;'></i>
                        </button>
                    </div>
               </form>
            </div>
         </div>

    </div>



   <script src="{{ url('back') }}/poll_hr/assets/js/jquery-3.6.0.min.js"></script>
   <script src="{{ url('back') }}/poll_hr/assets/js/bootstrap.min.js"></script>
   {{-- <script src="{{ url('back') }}/poll_hr/assets/js/jquery.validate.min.js"></script> --}}
   {{-- <script src="{{ url('back') }}/poll_hr/assets/js/script.js"></script> --}}
    
   {{-- close div poll --}}
        <script>
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
    {{-- close div poll --}}


    {{-- send poll --}}
        <script>        
            $(document).on('click', '#sendPollBtn', function(e){
                e.preventDefault();

                const inputs = document.querySelectorAll('textarea');
                const allInputsValid = true;

                for(const input of inputs){

                    if(!input.value){
                        alert('من فضلك تأكد من الإجابة علي جميع أسئلة الإستبيان !!');
                    }else{
                        let url = "{{ url('dashboard/polls_hr/poll_users_hr_teachers') }}";
                        $.ajax({
                            type: "post",
                            headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                            url: url,
                            data: $("form").serialize(),
                            success: function (res) {  
                                if (res.success) {
                                    alert(res.message);
                                    window.location.href = "{{ url('dashboard') }}";
                                }                          
                            }
                        });  
                    } // end if

                } // end for       
            });
        </script>
    {{-- send poll --}}
    
</body>
</html>