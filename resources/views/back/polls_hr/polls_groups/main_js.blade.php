<script>
    $(document).ready(function () {
        const pollsGroupModal = '#pollsGroupModal';
        

        //////////////// when click to add button
        $(document).on('click', '.add_modal', function(){
            $(`${pollsGroupModal} .modal-header h5`).text('اضافة ( مجموعة إستبيان للإدارة أو المدرسين )');
            $(`${pollsGroupModal} .save`).css('display', 'inline');
            $(`${pollsGroupModal} .update`).css('display', 'none');
            $(`${pollsGroupModal} form input`).not('[name="_token"]').val('');
            $(`${pollsGroupModal} form select`).find('option:first').prop('selected', true);
        });


        //////////////// when click to button save form
        $(document).on('click', `${pollsGroupModal} form .save`, function(e){
            e.preventDefault();
            
            let url = "{{ url('dashboard/polls_hr/polls_groups') }}";
            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: $(`${pollsGroupModal} form`).serialize(),
                success: function (res) {
                    $('.modal').modal('hide');
                    $('#polls_groups_table').DataTable().ajax.reload( null, false );
                    
                    $(`${pollsGroupModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsGroupModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تمت إضافة مجموعة الإستبيان بنجاح ",
                        type: "success",
                    });

                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsGroupModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsGroupModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });
        });


        //////////////// when click to edit button
        $(document).on('click', '#polls_groups_table .edit_modal', function(){
            $(`${pollsGroupModal} .modal-header h5`).text('تعديل ( مجموعة إستبيان )');
            $(`${pollsGroupModal} .save`).css('display', 'none');
            $(`${pollsGroupModal} .update`).css('display', 'inline');
            $(`${pollsGroupModal} form input`).not('[name="_token"]').val('');
            $(`${pollsGroupModal} form select`).find('option:first').prop('selected', true);

            const res_id = $(this).attr('res_id');
            let url = "{{ url('dashboard/polls_hr/polls_groups/edit') }}"+'/'+res_id;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                success: function (res) {                            
                    notif({ msg: "تمت جلب البيانات بنجاح ", type: "success"});

                    $.each(res, function (index, value){
                        $(`${pollsGroupModal} #${index}`).val(value);

                        if(index === 'id'){
                            $(`${pollsGroupModal} #res_id`).val(value);
                        }
                    });


                },
                beforeSend:function () {
                    $(`${pollsGroupModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsGroupModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });            
        });


        //////////////// when click to button update form
        $(document).on('click', `${pollsGroupModal} form .update`, function(e){
            e.preventDefault();
            
            const res_id = $(`${pollsGroupModal} #res_id`).val();
            let url = "{{ url('dashboard/polls_hr/polls_groups/update') }}"+'/'+res_id;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: url,
                data: $(`${pollsGroupModal} form`).serialize(),
                success: function (res) {
                    $('.modal').modal('hide');
                    $('#polls_groups_table').DataTable().ajax.reload( null, false );
                    
                    $(`${pollsGroupModal} form input`).not('[name="_token"]').val('');
                    $(`${pollsGroupModal} form select`).find('option:first').prop('selected', true);
                    
                    notif({
                        msg: "تم تعديل مجموعة الإستبيان بنجاح ",
                        type: "success",
                    });

                    window.location.reload();
                },
                beforeSend:function () {
                    $(`${pollsGroupModal} form [id^=errors]`).text('');
                },
                error: function (res) {
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`${pollsGroupModal} form #errors-${index}`).css('display' , 'block').text(value);
                    });
                }
            });
        });




        //////////////// datatable
        $('#polls_groups_table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                sUrl : "{{ url('back/assets/js/ar.json') }}"
            },
            ajax: "{{ url('dashboard/polls_hr/polls_groups/datatable') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'special', name: 'special'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ],
            order: [[0, "DESC"]]
        });      
    
    });
</script>