<script>
    $(document).ready(function () {
        const pollsQuestionsModal = '#pollsQuestionsModal';
        



        
        //////////////// when click to add button
        $(document).on('click', '.add_modal', function(){
            $(`${pollsQuestionsModal} .modal-header h5`).text('اضافة ( أسئلة استبيان للإدارة أو المدرسين )');
            $(`${pollsQuestionsModal} .save`).css('display', 'inline');
            $(`${pollsQuestionsModal} .update`).css('display', 'none');
            $(`${pollsQuestionsModal} form input`).not('[name="_token"]').val('');
            $(`${pollsQuestionsModal} form select`).find('option:first').prop('selected', true);
        });
        //////////////// when click to add button






        //////////////// when change نوع السؤال الي سؤال مقالي
        $(document).on('click', '#type', function(){
            if($(this).val() == 'textarea'){
                $("#percentage").val(0);
            }else{
                $("#percentage").val('');
            }
        });
        //////////////// when change نوع السؤال الي سؤال مقالي





        //////////////// when click to button save form
        $(document).on('click', `${pollsQuestionsModal} form .save`, function(e){
            e.preventDefault();
            
            let url = "{{ url('dashboard/polls_hr/polls_questions') }}";
            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: $(`${pollsQuestionsModal} form`).serialize(),
                success: function (res) {
                    $('.modal').modal('hide');
                    $('#polls_questions_table').DataTable().ajax.reload( null, false );
                    
                    $(`${pollsQuestionsModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsQuestionsModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تمت الإضافة بنجاح ",
                        type: "success",
                    });

                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });
        });


        //////////////// when click to edit button
        $(document).on('click', '#polls_questions_table .edit_modal', function(){
            $(`${pollsQuestionsModal} .modal-header h5`).text('تعديل ( أسئلة استبيان للإدارة )');
            $(`${pollsQuestionsModal} .save`).css('display', 'none');
            $(`${pollsQuestionsModal} .update`).css('display', 'inline');
            $(`${pollsQuestionsModal} form input`).not('[name="_token"]').val('');
            $(`${pollsQuestionsModal} form select`).find('option:first').prop('selected', true);

            const res_id = $(this).attr('res_id');
            let url = "{{ url('dashboard/polls_hr/polls_questions/edit') }}"+'/'+res_id;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                success: function (res) {                            
                    notif({ msg: "تمت جلب البيانات بنجاح ", type: "success"});

                    $.each(res, function (index, value){
                        $(`${pollsQuestionsModal} #${index}`).val(value);

                        if(index === 'id'){
                            $(`${pollsQuestionsModal} #res_id`).val(value);
                        }
                        if(index === 'question'){
                            $(`${pollsQuestionsModal} #question`).val(JSON.parse(value));
                        }
                    });


                },
                beforeSend:function () {
                    $(`${pollsQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });            
        });


        //////////////// when click to button update form
        $(document).on('click', `${pollsQuestionsModal} form .update`, function(e){
            e.preventDefault();
            
            const res_id = $(`${pollsQuestionsModal} #res_id`).val();
            let url = "{{ url('dashboard/polls_hr/polls_questions/update') }}"+'/'+res_id;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: $(`${pollsQuestionsModal} form`).serialize(),
                success: function (res) {
                    $('.modal').modal('hide');
                    $('#polls_questions_table').DataTable().ajax.reload( null, false );
                    
                    $(`${pollsQuestionsModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsQuestionsModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تم التعديل بنجاح ",
                        type: "success",
                    });

                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsQuestionsModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsQuestionsModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });
        });




        //////////////// datatable
        $('#polls_questions_table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                sUrl : "{{ url('back/assets/js/ar.json') }}"
            },
            ajax: "{{ url('dashboard/polls_hr/polls_questions/datatable') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'group', name: 'group'},
                {data: 'type', name: 'type'},
                {data: 'question', name: 'question'},
                {data: 'percentage', name: 'percentage'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ],
            order: [[0, "DESC"]]
        });      
    
    });
</script>