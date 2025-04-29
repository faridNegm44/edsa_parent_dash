<script>
    $(document).on("change" , ".TheYear", function(){
        let the_year_length_attr = $(this).attr('the_year_length_attr');
        let years_val = $(this).val();
        let main_div_id = $(this).parent().parent().parent().parent().attr('main_div_id');

        $(".TheMats_"+main_div_id+ " option").remove();
        $(".main_div_form_"+main_div_id+" table tbody tr").remove();

        let act = "{{ url('dashboard/cost/get_mat_after_change_years') }}"+"/"+years_val+"/"+main_div_id;
        $.ajax({
            type: "get",
            headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            url: act,
            data: { 
                the_year: $(".TheYear").val()
            },
            success: function (res) {
                for(key in res){
                    $(".TheMats_"+main_div_id).append(`
                        <option value="`+res[key].TheMat+`">`+res[key].TheMat+`</option>
                    `);
                }
                
                notif({
                    msg: "تمت جلب المواد الخاصه بالصف الدراسي",
                    type: "success",
                });
            },
            error: function (res) {

            }
        });
    });
</script>