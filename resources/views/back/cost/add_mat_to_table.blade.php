<script>
    $(document).on("change" , ".TheMats", function(){
       let attr_id = $(this).attr('id');
       let this_val = $(this).val();
       let parent_id = $(this).parent().parent().parent().parent().attr('main_div_id');

       $(".main_div_form_"+parent_id+" table tbody").append(`
            <tr>
                <td>
                    <input class="" type="checkbox" checked id="`+this_val+`" value="`+this_val+`" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                    <label for="`+this_val+`">`+this_val+`</label>
                </td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
       `);
    });
</script>