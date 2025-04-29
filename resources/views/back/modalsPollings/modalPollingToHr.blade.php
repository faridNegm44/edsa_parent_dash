@if ($checkPollGroupsActivesNull != null)     

    @if ($checkPollGroupsToHrOrTeachers == 'hr')        

        @if ($checkIfUserPolledToHr == null)

            <div class="modal fade poll_div_modal" data-keyboard="false" data-backdrop="static" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="poll_div">
                            <button type="button" class="btn btn-danger fixed-bottom close-button" data-bs-toggle="tooltip" data-bs-placement="top" title="إغلاق الإستبيان">
                                <i class="fas fa-times"></i>
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
                                    <h4 class="text-center heading_section">( {{ $pollGroupsActives[0]->title }} )</h4>
                                    <form class="multisteps_form position-relative" id="wizard" style="margin-top: 25px;">
                                        @csrf
                                        <input type="hidden" name="group_id" value="{{ $pollGroupsActives[0]->id }}">
                                        
                                        @foreach ($questions as $question)
                                            <div class="multisteps_form_panel" >
                    
                                                <span class="question_number text-uppercase d-flex justify-content-center align-items-center" style="color: #d50808;text-decoration: u7derline;font-size: 17px;">
                                                    @if ($loop->iteration === 1)
                                                        الأسئلة {{ $loop->iteration }}/{{ $questions->count() }}                                    
                                                    @else
                                                        السؤال {{ $loop->iteration }}                                    
                                                    @endif
                                                </span>
                                                <h4 class="text-center" style="font-weight: bolder;">
                                                    {{ json_decode($question->question) }}
                                                </h4>
                                                
                                                <div class="form_items justify-content-center">     
                                                    
                                                    {{----------------- start check type question ------------------}}
                                                    @if ($question->type == 'radio')
                                                        <ul class="ps-0">
                                                            <div class="row" style="display: flex; justify-content: center">
                                                                @foreach ($question->answers as $answer)     
                                                                    @if ($answer->status == 1)                                                                    
                                                                        <div class="col-md-3 col-sm-12 step_1 rounded-pill bg-white text-center animate__animated animate__fadeInRight animate_50ms" style="margin: 5px">
                                                                            <input 
                                                                                type="{{ $question->type }}" 
                                                                                id="opt_{{ $question->id.'_'.$answer->answer }}" 
                                                                                name="{{ $question->id }}" 
                                                                                value="{{ $answer->id }}_{{ $answer->percentage }}" 
                                                                                {{ $loop->iteration == 1 ? 'checked' : '' }} 
                                                                            />

                            
                                                                            <label for="opt_{{ $question->id.'_'.$answer->answer }}">
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
                                                            name="{{ $question->id }}"
                                                            class="form-control rounded-pill" 
                                                            value="{{ date('Y-m-d') }}"
                                                            style="margin: 0 auto;width: 40%;text-align: center;padding-top: 30px;padding-bottom: 30px;font-weight: bold;"
                                                        />  

                                                    @elseif ($question->type == 'textarea')
                                                        <textarea name="{{ $question->id }}" class="form-control" style="height: 120px;width: 90%;margin: 25px auto;border-radius: 26px;padding: 10px 20px;" placeholder="{{ json_decode($question->question) }}"></textarea>
                                                    @endif 

                                                    {{----------------- end check type question ------------------}}
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
                    
                    </div>
                </div>
                </div>
            </div> 

        @endif

    @endif

@endif