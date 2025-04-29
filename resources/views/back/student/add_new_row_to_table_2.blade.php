<script>
    $(document).on('click', '#table1 tbody tr .matt_checkbox', function(){
            var this_val = $(this).val();

            if($(this).is(':checked')){
                var mat_id = $(this).val();
                var mat_name = $(this).attr('id');
                var student_id = $('#student_id').val();
                var TheTime = $(".TheTime_"+mat_id).val();
                var ThePackage = $(".ThePackage_"+mat_id).val();
                var TheNotes = $(".TheNotes_"+mat_id).val();
                var year_name = $("#YearID").val();
                var desires_count = $("#table2 tbody tr").length;
                
                // alert('.td_'+mat_id+" input");
                // $(this).parent().parent().remove();

                if($("#table2 tbody #tr_"+mat_id+" .first_td input").val() === mat_id){
                    alert('!!!!!  هذه الماده تمت اضافتها من قبل ولايمكن إضافتها مره أخري !!!!!');
                }else{
                    $("#mat_form #table2 tbody").append(`
                        <tr id="tr_`+mat_id+`">
                            <td class="first_td">
                                <label for="`+mat_name+`">`+mat_name+`</label>
                                <input class="form-control" type="hidden" readonly id="" value="`+mat_id+`" name="new_matt[]" />
                            </td>
                            <td>
                                <label for="" style="margin-top: 10px;">`+year_name+`</label>
                                <input class="form-control" type="hidden" readonly id="" value="1" name="years[]" />
                            </td>
                            <td>
                                <select class="form-control TheTime" id="TheTime" name="new_TheTime[]" style="width: 100%;">
                                    <option value="صباحا" selected>
                                        صباحا
                                    </option>
                                    <option value="مساءا">
                                        مساءا
                                    </option>
                                </select>
                                
                            </td>
                            <td>
                                <select class="form-control ThePackage" id="ThePackage" name="new_ThePackage[]" style="width: 100%;">
                                    <option value="باقة 1 طالب">
                                        باقة 1 طالب
                                    </option>
                                    <option value="باقة 2 طالب">
                                        باقة 2 طالب
                                    </option>
                                    <option value="باقة 3-6 طالب">
                                        باقة 3-6 طالب
                                    </option>
                                    <option value="باقة التوفير" selected>
                                        باقة التوفير
                                    </option>
                                </select>
                            </td>
                            <td>
                                <a id="`+mat_id+`" class="text-muted option-dots2 delete_desire" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>
                            </td>
                        </tr>
                    `);

                    $("#desires_count").text(desires_count+1);
                }
            }
    });
</script>