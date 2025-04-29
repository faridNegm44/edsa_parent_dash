<form>
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">                
                <div class="col-md-12">
                    <label for="year">الصفوف الدراسيه</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="width: 100%;">
                            <span class="input-group-text"><i class="fa fa-flag"></i></span>
                        <select class="form-control select2_select2" id="year" name="year" style="width: 100%;">
                            <option value="---">
                                ---
                            </option>
                            @foreach ($years as $item)
                                <option value="{{ $item->TheYear }}">
                                    {{ $item->TheYear }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <p class="errors" id="errors-NatID"></p>
                </div>
            </div>

            <br />

            <div class="section_count_of_shares" id="section_count_of_shares">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ماده</th>
                            <th>عدد الحصص</th>
                            <th>أكشن</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="save">حفظ</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>

<script>
    $('.modal-title').html("إضافه عدد حصص");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });

        // Change The Year To Get Mats And Add First Row
        $("form #year").change(function(){
            let years_val = $(this).val();
           let act = "{{ url('dashboard/students/get_mat_after_change_years') }}"+"/"+years_val;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('form').serialize(),
                success: function (res) {
                    $("#section_count_of_shares table tbody tr").remove();

                    console.log(res)
                    for(key in res){
                        $("#section_count_of_shares table tbody").append(`
                            <tr>
                                <td>
                                    <input type="text" readonly class="form-control" value="`+res[key].TheMat+`" />
                                    <input type="text" hidden class="form-control" value="`+res[key].ID+`" id="mat" name="mat[]" />
                                </td>
                                
                                <td>
                                    <input type="number" class="form-control" id="count" name="count" placeholder="عدد الحصص"/>
                                </td>
                                
                                <td>
                                    <p class="text-muted option-dots2" style="display: inline;margin: 0px 5px;">
                                        <i class="fa fa-plus" style="color: rgb(13, 175, 13);font-size: 17px;"></i>
                                    </p>

                                    <p class="text-muted option-dots2" style="display: inline;margin: 0px 8px;" >
                                        <i class="fa fa-trash" style="color: #f35f5f;font-size: 17px;"></i>
                                    </p>
                                </td>
                            </tr>
                        `);
                    }                     
                },
                error: function (res) {

                }
            });
        });



        $(".modal #save").click(function(e) {
            e.preventDefault();
            
            let act = "{{ url('dashboard/students/store') }}";
            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('form').serialize(),
                success: function (res) {
                    $('input').val('');
                    $('.modal').modal('hide');
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تمت الإضافه بنجاح",
                        type: "success",
                    });
                },
                error: function (res) {
                    if(res.responseJSON.errors.TheName){
                        $("form #errors-TheName").css('display' , 'block').text(res.responseJSON.errors.TheName);
                    }else{
                        $("form #errors-TheName").text('');
                    }
                    if(res.responseJSON.errors.NatID){
                        $("form #errors-NatID").css('display' , 'block').text(res.responseJSON.errors.NatID);
                    }else{
                        $("form #errors-NatID").text('');
                    }
                    if(res.responseJSON.errors.CityID){
                        $("form #errors-CityID").css('display' , 'block').text(res.responseJSON.errors.CityID);
                    }else{
                        $("form #errors-CityID").text('');
                    }
                    if(res.responseJSON.errors.ThePhone){
                        $("form #errors-ThePhone").css('display' , 'block').text(res.responseJSON.errors.ThePhone);
                    }else{
                        $("form #errors-ThePhone").text('');
                    }
                    if(res.responseJSON.errors.TheEmail){
                        $("form #errors-TheEmail").css('display' , 'block').text(res.responseJSON.errors.TheEmail);
                    }else{
                        $("form #errors-TheEmail").text('');
                    }
                    if(res.responseJSON.errors.TheEduType){
                        $("form #errors-TheEduType").css('display' , 'block').text(res.responseJSON.errors.TheEduType);
                    }else{
                        $("form #errors-TheEduType").text('');
                    }
                    if(res.responseJSON.errors.TheTestType){
                        $("form #errors-TheTestType").css('display' , 'block').text(res.responseJSON.errors.TheTestType);
                    }else{
                        $("form #errors-TheTestType").text('');
                    }
                    if(res.responseJSON.errors.TheExplain){
                        $("form #errors-TheExplain").css('display' , 'block').text(res.responseJSON.errors.TheExplain);
                    }else{
                        $("form #errors-TheExplain").text('');
                    }
                    if(res.responseJSON.errors.TheNotes){
                        $("form #errors-TheNotes").css('display' , 'block').text(res.responseJSON.errors.TheNotes);
                    }else{
                        $("form #errors-TheNotes").text('');
                    }
                    if(res.responseJSON.errors.TheStatus){
                        $("form #errors-TheStatus").css('display' , 'block').text(res.responseJSON.errors.TheStatus);
                    }else{
                        $("form #errors-TheStatus").text('');
                    }
                    if(res.responseJSON.errors.TheStatusDate){
                        $("form #errors-TheStatusDate").css('display' , 'block').text(res.responseJSON.errors.TheStatusDate);
                    }else{
                        $("form #errors-TheStatusDate").text('');
                    }
                }
            });
            
        });
    });
    
</script>