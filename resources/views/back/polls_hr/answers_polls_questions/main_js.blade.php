<script>
    $(document).ready(function () {
        const pollsAnswersToQuestionsModal = '#pollsAnswersToQuestionsModal';
        

        //////////////// when click to add button
        $(document).on('click', '.add_modal', function(){
            $(`${pollsAnswersToQuestionsModal} .modal-header h5`).text('اضافة ( إجابات لأسئلة استبيان الإدارة أو المدرسين )');
            $(`${pollsAnswersToQuestionsModal} .save`).css('display', 'inline');
            $(`${pollsAnswersToQuestionsModal} .update`).css('display', 'none');
            $(`${pollsAnswersToQuestionsModal} form input`).not('[name="_token"]').val('');
            $(`${pollsAnswersToQuestionsModal} form select`).find('option:first').prop('selected', true);
        });


        //////////////// when click to button save form
        $(document).on('click', `${pollsAnswersToQuestionsModal} form .save`, function(e){
            e.preventDefault();
            
            let url = "{{ url('dashboard/polls_hr/answers_polls_questions') }}";
            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: $(`${pollsAnswersToQuestionsModal} form`).serialize(),
                success: function (res) {
                    $('#answers_to_polls_questions_table').DataTable().ajax.reload( null, false );
                    
                    $(`${pollsAnswersToQuestionsModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsAnswersToQuestionsModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تمت إضافة إجابات السؤال بنجاح ",
                        type: "success",
                    });


                    $(".answersDiv input").val('');
                    $(".answersDivAppended").remove();
                    $("#question").trigger('change.select2');


                    // $('.modal').modal('hide');
                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsAnswersToQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsAnswersToQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });
        });


        //////////////// when click to edit button
        $(document).on('click', '#answers_to_polls_questions_table .edit_modal', function(){
            $(`${pollsAnswersToQuestionsModal} .modal-header h5`).text('تعديل ( أسئلة استبيان للإدارة )');
            $(`${pollsAnswersToQuestionsModal} .save`).css('display', 'none');
            $(`${pollsAnswersToQuestionsModal} .update`).css('display', 'inline');
            $(`${pollsAnswersToQuestionsModal} form input`).not('[name="_token"]').val('');
            $(`${pollsAnswersToQuestionsModal} form select`).find('option:first').prop('selected', true);

            const res_id = $(this).attr('res_id');
            let url = "{{ url('dashboard/polls_hr/answers_polls_questions/edit') }}"+'/'+res_id;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                success: function (res) {                            
                    notif({ msg: "تمت جلب البيانات بنجاح ", type: "success"});

                    $.each(res, function (index, value){
                        $(`${pollsAnswersToQuestionsModal} #${index}`).val(value);

                        if(index === 'id'){
                            $(`${pollsAnswersToQuestionsModal} #res_id`).val(value);
                        }
                    });


                },
                beforeSend:function () {
                    $(`${pollsAnswersToQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsAnswersToQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });            
        });


        //////////////// when click to button update form
        $(document).on('click', `${pollsAnswersToQuestionsModal} form .update`, function(e){
            e.preventDefault();
            
            const res_id = $(`${pollsAnswersToQuestionsModal} #res_id`).val();
            let url = "{{ url('dashboard/polls_hr/answers_polls_questions/update') }}"+'/'+res_id;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: $(`${pollsAnswersToQuestionsModal} form`).serialize(),
                success: function (res) {
                    $('.modal').modal('hide');
                    $('#answers_to_polls_questions_table').DataTable().ajax.reload( null, false );
                    
                    $(`${pollsAnswersToQuestionsModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsAnswersToQuestionsModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تم تعديل إجابات السؤال بنجاح ",
                        type: "success",
                    });

                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsAnswersToQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsAnswersToQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });
        });



        //////////////// show answers
        $(document).on('click', '#answers_to_polls_questions_table .show_answers', function(){
            const res_id = $(this).attr('res_id');
            const title = $(this).attr('title');
            const questionPercentage = $(this).attr('questionPercentage');
            let url = "{{ url('dashboard/polls_hr/answers_polls_questions/show_answers') }}"+'/'+res_id;
            
            $(`#answersModal .modal-header h5`).text(`السؤال: ${title}`);

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                success: function (res) {
                    $.each(res, function(index, value){
                        $(`#answersModal .modal-body`).append(`
                            <form>
                                <input type="hidden" id="questionPercentage" name="questionPercentage" value='${questionPercentage}' />
                                @csrf
                                <div class="row" style="margin-bottom: 12px;" >
                                    <div class="col-md-5">
                                        <input type="text" class="form-control answer" value="${JSON.parse(value.answer)}" name="answer" />    
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <input type="text" class="form-control answer_value" value="${value.value}" name="answer_value" />    
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <select class="form-control status" name="status">
                                            <option value="1" ${value.status == 1 ? 'selected' : '' }>نشط</option>
                                            <option value="0" ${value.status == 0 ? 'selected' : '' }>غير نشط</option>
                                        </select>   
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary save" answer_id="${value.id}">حفظ</button>
                                    </div>
                                </div>
                            </form>
                        `);
                    });
                },
                beforeSend:function () {
                    $(`#answersModal .modal-body`).html('');
                }
            });
        });



        //////////////// change answers
        $(document).on('click', '#answersModal .modal-body .save', function(e){
            e.preventDefault();

            const answer_id = $(this).attr('answer_id');
            const answer = $(this).closest('.row').find('.answer').val();
            const answer_value = $(this).closest('.row').find('.answer_value').val();
            const status = $(this).closest('.row').find('.status').val();
            const questionPercentage = $("#questionPercentage").val();

            let url = "{{ url('dashboard/polls_hr/answers_polls_questions/update_answer') }}"+'/'+answer_id;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: {
                    answer: answer,
                    answer_value: answer_value,
                    questionPercentage: questionPercentage,
                    status: status
                },
                success: function (res) {
                    notif({
                        msg: "تم تحديث الإجابة بنجاح ",
                        type: "success",
                    });
                }
            });
        });



        //////////////// datatable
        $('#answers_to_polls_questions_table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                sUrl : "{{ url('back/assets/js/ar.json') }}"
            },
            ajax: "{{ url('dashboard/polls_hr/answers_polls_questions/datatable') }}",
            columns: [
                {data: 'group', name: 'group'},
                {data: 'question', name: 'question'},
            ],
            order: [[0, "DESC"]]
        });      
    
    });


    // add new answer input when click this button (btn_add_new_answer)
    const btn_add_new_answer = document.querySelector("#btn_add_new_answer");
    btn_add_new_answer.addEventListener('click', function(e){
        e.preventDefault();

        $("#answer_section").append(`
            <div class="answersDivAppended row row-xs">
                <div class="col-md-6 col-sm-6">
                    <label for="answer">
                        الإجابة
                    </label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="answer" name="answer[]" placeholder="الإجابة" type="text" value="" />
                    </div>
                    <p class="errors" id="errors-answer"></p>
                </div>   
    
                <div class="col-md-3 col-sm-3">
                    <label for="answer_value">نسبة مئوية %</label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="answer_value" name="answer_value[]" placeholder="نسبة مئوية %" type="number" value="" />
                    </div>
                    <p class="errors" id="errors-answer_value"></p>
                </div>
                
                <div class="col-md-3 col-sm-3">
                    <label for="status">حالة الإجابة</label>
                    <div class="input-group mb-3">
                        <select class="form-control" name="status[]" id="status">
                            <option value="1">نشط</option>
                            <option value="0">غير نشط</option>
                        </select>
                    </div>
                    <p class="errors" id="errors-status"></p>
                </div>
            </div>
        `);

    });
</script>