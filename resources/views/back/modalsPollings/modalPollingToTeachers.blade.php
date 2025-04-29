@if ($checkPollGroupsActivesNull != null)  
        
    @if ($checkPollGroupsToHrOrTeachers == 'teachers')    

        @if ($studentsRelParentToGetTeachersToPolling->isNotEmpty())  

            @if ($checkIfUserPolledToTeachers == null)
                <div class="modal fade poll_div_modal" data-keyboard="false" data-backdrop="static" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="poll_div">                    
                                <button type="button" class="btn btn-danger fixed-bottom close-button" data-bs-toggle="tooltip" data-bs-placement="top" title="إغلاق الإستبيان">
                                    <i class="fas fa-times"></i>
                                </button>

                                <div class="wrapper pt-5" style="background-color: #adc7fb;
                                background-image: linear-gradient(25deg, #adc7fb 0%, #dedede 31%, #f3e4c3 73%);
                                ">
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
                                        <h4 class="text-center heading_section">( {{ $pollGroupsActives[0]->title }} )</h4>
                                        <form class="multisteps_form position-relative" id="wizard" style="margin-top: 25px;">
                                            @csrf
                                            <input type="hidden" name="group_id" value="{{ $pollGroupsActives[0]->id }}">
                                            
                                            @foreach($studentsRelParentToGetTeachersToPolling as $teacher)   {{-- start loop to teachers --}}
                                                <h3 class="h3_teacher_name">{{ $teacher->teacher_name }}</h3>
                                
                                                @foreach ($questions as $question)   {{-- start loop to questions --}} 
                                                    <div class="multisteps_form_panel" >                            
                                                        {{-- <h4 class="text-center" style="font-weight: bolder;">{{ $question->question }}</h4> --}}
                                                        <h5 class="text-center" style="line-height: 25px !important;font-size: 17px !important;">{!! nl2br(e(json_decode($question->question))) !!}</h5>

                                                        <div class="form_items justify-content-center">                            
                                                            @if ($question->type == 'radio')
                                                                <ul class="ps-0">
                                                                    <div class="row" style="display: flex; justify-content: center">
                                                                        @foreach ($question->answers as $answer)     
                                                                            @if ($answer->status == 1)                                                                    
                                                                                <div class="col-md-2 col-sm-12 step_1 rounded-pill bg-white text-center animate__animated animate__fadeInRight animate_50ms" style="margin: 5px">
                                                                                    <input 
                                                                                        type="radio" 
                                                                                        id="opt_{{ $teacher->teacher_id }}_{{ $question->id.'_'.$answer->answer }}" 
                                                                                        name="{{ $teacher->teacher_id }}_{{ $question->id }}" 
                                                                                        value="{{ $teacher->teacher_id }}_{{ $answer->id }}_{{ $answer->percentage }}" 
                                                                                        {{ $loop->iteration == 1 ? 'checked' : '' }} 
                                                                                    />
                                    
                                                                                    <label for="opt_{{ $teacher->teacher_id }}_{{ $question->id.'_'.$answer->answer }}">
                                                                                        {{ json_decode($answer->answer) }}
                                                                                    </label>
                                                                                </div>                                        
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </ul>

                                                            @elseif ($question->type == 'date')
                                                                <input 
                                                                    type="date" 
                                                                    class="form-control rounded-pill" 
                                                                    name="{{ $teacher->teacher_id }}_{{ $question->id }}" 
                                                                    style="margin: 0 auto;width: 40%;text-align: center;padding-top: 30px;padding-bottom: 30px;font-weight: bold;"
                                                                />  

                                                            @elseif ($question->type == 'textarea')
                                                                <textarea class="form-control" style="height: 120px;width: 90%;margin: 25px auto;border-radius: 26px;padding: 10px;" name="{{ $teacher->teacher_id }}_{{ $question->id }}"></textarea>
                                                            @endif                                
                                                        </div>
                                                    </div>   
                                                    
                                                    @if ($loop->last != true)                            
                                                        <hr />
                                                    @endif
                                                @endforeach   {{-- end loop to questions --}}                                                                                        

                                                @if ($loop->last != true)      
                                                    <div style="padding: 30px 0;">
                                                        <hr style="padding: 1px;background: #7c4545;">
                                                    </div>
                                                @endif
                                            @endforeach   {{-- end loop to teachers --}}                                                                       
                        
                                            <div class="form_btn d-flex justify-content-center align-items-center ms-5 mt-5">
                                                <button type="button" class="f_btn rounded-pill border-0" id="sendPollBtnTeachers">
                                                    إرسال التقييم <i class='fas fa-chevron-left' style='position: relative;top: 3px;right: 7px;'></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        
                            </div>
                        
                        </div>
                    </div>
                    </div>
                </div>   
            @endif

        @endif {{-- $studentsRelParentToGetTeachersToPolling != null --}}

    @endif {{-- $checkPollGroupsToHrOrTeachers == 'teachers' --}}

@endif