<div class="modal fade" id="pollsAnswersToQuestionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <form>
                @csrf

                <input type="hidden" name="res_id" id="res_id" value="">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">                    
                    <div class="modal-body">
                        <div class="pd-30 pd-sm-40 bg-gray-100">
                            <div class="">
                                <label for="question">السؤال</label>
                                <select class="form-control select2_select2" name="question" style="width: 100%;" id="question">
                                    <option value="">---</option>
                                    @foreach ($polls_questions as $question)       

                                        <option value="{{ $question->id }}_{{ $question->percentage }}">

                                            <span style="font-weight: bold;">
                                                    م_{{ $question->group_id }} ( {{ $question->group_title }} )
                                            </span> - 
                                            {{ json_decode($question->question) }}

                                        </option>

                                    @endforeach
                                </select>
                                <p class="errors" id="errors-question"></p>
                            </div>  

                            <div id="answer_section">

                                <div class="answersDiv row row-xs">
                                    <div class="col-md-6 col-sm-6">
                                        <label for="answer">
                                            الإجابة
                                            <button id="btn_add_new_answer" style="width: 30px !important;height: 27px;font-size: 10px;margin: 5px 10px;background: #e95050;color: #fff;border: 0px;"><i class="fa fa-plus"></i></button>
                                        </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" id="answer" name="answer[]" placeholder="الإجابة" type="text" value="" />
                                        </div>
                                        <p class="errors" id="errors-answer"></p>
                                    </div>   
                                    
                                    <div class="col-md-3 col-sm-3">
                                        <label for="answer_value" style="margin-bottom: 22px;">نسبة مئوية %</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" id="answer_value" name="answer_value[]" placeholder="نسبة مئوية %" type="number" value="" />
                                        </div>
                                        <p class="errors" id="errors-answer_value"></p>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3">
                                        <label for="status" style="margin-bottom: 22px;">حالة الإجابة</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control" name="status[]" id="status">
                                                <option value="1">نشط</option>
                                                <option value="0">غير نشط</option>
                                            </select>
                                        </div>
                                        <p class="errors" id="errors-status"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>                                                                  
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save" style="display: none;">حفظ</button>
                    <button type="submit" class="btn btn-success update" style="display: none;">تعديل</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                </div>
            </form>  
        </div>
    </div>
</div>    