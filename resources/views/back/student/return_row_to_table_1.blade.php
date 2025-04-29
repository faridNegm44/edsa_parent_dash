<script>
    // $(document).on('click', '#table2 tbody tr .matt_checkbox', function(){
    //         var this_val = $(this).val();
    //         var desires_count = $("#table2 tbody tr").length;
    //         $("#desires_count").text(desires_count-1);

    //         if(!$(this).is(':checked')){
    //             var mat_id = $(this).val();
    //             var mat_name = $(this).attr('id');

    //             $(this).parent().parent().remove();

    //             $("#mat_form #table1 tbody").append(`
    //                 <tr>
    //                     <td>
    //                         <input class="matt_checkbox" type="checkbox" id="`+mat_name+`" value="`+mat_id+`" name="YearID[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
    //                         <label for="`+mat_name+`">`+mat_name+`</label>
    //                     </td>
    //                 </tr>
    //             `);
    //         }
    // });

    $(document).on('click', '#table2 tbody tr .delete_desire', function(){
        var confirm_msg = confirm('هل انت متاكد من الحذف');
        if(confirm_msg){
            let id = $(this).attr('id');
            let student_id = $(this).attr('student_id');
            let act = "{{ url('dashboard/students/destroy_desire_to_student') }}"+"/"+id+"/"+student_id;

            var desires_count = $("#table2 tbody tr").length;
            $("#desires_count").text(desires_count-1);
            $(this).parent().parent().remove();

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('#mat_form').serialize(),
                success: function (res) {
                                        
                }                    
            });
        }
    });

</script>