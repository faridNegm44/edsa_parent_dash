<form id="mat_form">
    @csrf
    <input id="group_id" type="hidden" value="{{ $group_id['group_id'] }}">

    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <label for="StudentID">الطلاب</label><span style="color: red;font-size: 14px;margin: 0px 10px;">( أختر طالب أولا )</span>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="width: 100%;">
                            <span class="input-group-text"><i class="fa fa-child"></i></span>
                        <select class="form-control select2_select2" id="StudentID" name="StudentID" style="width: 100%;">
                            <option value="">
                                ---
                            </option>
                            @foreach ($students as $item)
                                <option value="{{ $item->ID }}" {{ $item->ID == $student['StudentID'] ? 'selected' : null }}>
                                    {{ $item->TheName }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <p class="errors" id="errors-StudentID"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="YearID">الصفوف الدراسيه</label><span style="color: red;font-size: 14px;margin: 0px 10px;">( إختر صف دراسي لإظهار المواد المتعلقه به )</span>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="width: 100%;">
                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                        <select class="form-control select2_select2" id="YearID" name="YearID" style="width: 100%;">
                            <option value="">
                                ---
                            </option>
                            @foreach ($years as $item)
                                <option value="{{ $item->TheYear }}" {{ $item->TheYear == $year['TheYear'] ? 'selected' : null }}>
                                    {{ $item->TheYear }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <p class="errors" id="errors-YearID"></p>
                </div>
                                
                <div class="col-md-12" style="margin-top: 20px;" id="TheMat">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="label_mats" style="margin-bottom: 20px;font-size: 15px;">المواد الدراسيه طبقا للصف الدراسي</label>
                            <table class="table table-bordered table1" id="table1" style="background: #FFF;">
                                <thead>
                                    <tr>
                                        <th>الماده</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($get_all_mats_after_get_year as $item)
                                        <tr class="{{ $item->ID }}">
                                            <td>
                                                <input class="matt_checkbox" type="checkbox" id="{{ $item->TheMat }}" value="{{ $item->ID }}" name="YearID[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                                                <label for="{{ $item->TheMat }}">{{ $item->TheMat }}</label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-lg-9">
                            <label class="label_mats" style="margin-bottom: 20px;font-size: 15px;">المواد المختاره</label>
                            <table class="table table-bordered table2" id="table2" style="background: #FFF;">
                                <thead>
                                    <tr>
                                        <th>الماده</th>
                                        <th>الفتره</th>
                                        <th>الباقه</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($get_mats_selected as $item)
                                    <tr class="{{ $item->ID }}">
                                        <td>
                                            <input class="matt_checkbox" checked type="checkbox" id="{{ $item->TheMat }}" value="{{ $item->ID }}" name="new_matt[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                                            <label for="{{ $item->mats_name['TheMat'] }}">{{ $item->mats_name['TheMat'] }}</label>
                                        </td>
                                        <td>
                                            
                                            <select class="form-control time time_{{ $item->ID }}" mat_id="{{ $item->ID }}" id="time" name="new_time[]" style="width: 100%;">
                                                <option value="---">
                                                    ---
                                                </option>
                                                <option value="1" class="after_time_{{ $item->ID }}" {{ $item->time == 1 ? 'selected' : null }}>
                                                    صباحا
                                                </option>
                                                <option value="2" class="night_time_{{ $item->ID }}" {{ $item->time == 2 ? 'selected' : null }}>
                                                    مساءا
                                                </option>
                                            </select>
                                            
                                        </td>
                                        <td>
                                            <select class="form-control package package_{{ $item->ID }}" mat_id="{{ $item->ID }}" id="package" name="new_package[]" style="width: 100%;">
                                                <option value="---">
                                                    ---
                                                </option>
                                                <option value="1" class="package_{{ $item->ID }}" {{ $item->package == 1 ? 'selected' : null }}>
                                                    باقه 1 طالب
                                                </option>
                                                <option value="2" class="package_{{ $item->ID }}" {{ $item->package == 2 ? 'selected' : null }}>
                                                    باقه 2 طالب
                                                </option>
                                                <option value="3" class="package_{{ $item->ID }}" {{ $item->package == 3 ? 'selected' : null }}>
                                                    باقه 3-6 طالب
                                                </option>
                                                <option value="4" class="saving_package_{{ $item->ID }}" {{ $item->package == 4 ? 'selected' : null }}>
                                                   باقه التوفير
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control notes notes_{{ $item->ID }}" mat_id="{{ $item->ID }}" name="new_notes[]" value="{{ $item->notes}}" placeholder="ملاحظات"/>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>                                                               
                                                                                                                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="update">حفظ الرغبات</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">خروج</button>
    </div>
</form>

<script>
    $('.modal-title').html("تعديل رغبات");

    $(document).ready(function(){
        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });


        ///////////////////////// Add Row To Table 2 After Checked Matt ///////////////////////////// 
        $(document).on('click', '#table1 tbody tr .matt_checkbox', function(){
            var this_val = $(this).val();

            if($(this).is(':checked')){
                var mat_id = $(this).val();
                var mat_name = $(this).attr('id');
                var time = $(".time_"+mat_id).val();
                var package = $(".package_"+mat_id).val();
                var notes = $(".notes_"+mat_id).val();
                
                $(this).parent().parent().remove();

                $("#mat_form #table2 tbody").append(`
                    <tr>
                        <td>
                            <input class="matt_checkbox" type="checkbox" checked id="`+mat_name+`" value="`+mat_id+`" name="new_matt[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                            <label for="`+mat_name+`">`+mat_name+`</label>
                        </td>
                        <td>
                            <select class="form-control time" id="time" name="new_time[]" style="width: 100%;">
                                <option value="---">
                                    ---
                                </option>
                                <option value="1" selected>
                                    صباحا
                                </option>
                                <option value="2">
                                    مساءا
                                </option>
                            </select>
                            
                        </td>
                        <td>
                            <select class="form-control package" id="package" name="new_package[]" style="width: 100%;">
                                <option value="---">
                                    ---
                                </option>
                                <option value="1">
                                    باقه 1 طالب
                                </option>
                                <option value="2">
                                    باقه 2 طالب
                                </option>
                                <option value="3">
                                    باقه 3-6 طالب
                                </option>
                                <option value="4" selected>
                                    باقه التوفير
                                </option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control notes" name="new_notes[]" placeholder="ملاحظات"/>
                        </td>
                    </tr>
                `);
            }
        });

        ///////////////////////// Return Row To Table 1 After Un Checked Matt ///////////////////////////// 
        $(document).on('click', '#table2 tbody tr .matt_checkbox', function(){
            var this_val = $(this).val();

            if(!$(this).is(':checked')){
                var mat_id = $(this).val();
                var mat_name = $(this).attr('id');

                $(this).parent().parent().remove();

                $("#mat_form #table1 tbody").append(`
                    <tr>
                        <td>
                            <input class="matt_checkbox" type="checkbox" id="`+mat_name+`" value="`+mat_id+`" name="YearID[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                            <label for="`+mat_name+`">`+mat_name+`</label>
                        </td>
                    </tr>
                `);
            }
        });

        ///////////////////////// Change The Years ///////////////////////////// 
        $("#YearID").change(function(){
           let years_val = $(this).val();
           let act = "{{ url('dashboard/students/get_mat_after_change_years') }}"+"/"+years_val;
           
            $("#mat_form input[name='new_matt[]']").remove();
            $("#mat_form input[name='new_time[]']").remove();
            $("#mat_form input[name='new_package[]']").remove();
            $("#mat_form input[name='new_notes[]']").remove();

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('#mat_form').serialize(),
                success: function (res) {
                    $("#TheMat table tbody tr").remove();
                    $("#TheMat").css('display', 'block');
                    $("form #errors-YearID").text('');

                    $("#mat_form input[name='new_matt[]']").remove();
                    $("#mat_form input[name='new_time[]']").remove();
                    $("#mat_form input[name='new_package[]']").remove();
                    $("#mat_form input[name='new_notes[]']").remove();

                    console.log(res)
                    for(key in res){
                    $("#TheMat #table1 tbody").append(`
                        <tr>
                            <td>
                                <input class="matt_checkbox" type="checkbox" id="`+res[key].TheMat+`" value="`+res[key].ID+`" name="YearID[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                                <label for="`+res[key].TheMat+`">`+res[key].TheMat+`</label>
                            </td>
                            
                        </tr>
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

        ///////////////////////// Update ///////////////////////////// 
        $("#mat_form #update").click(function(e) {
            e.preventDefault();
            let group_id = $("#group_id").val();
            let act = "{{ url('dashboard/students/update_desires') }}"+"/"+group_id;

            $matts = $("input[name=YearID]").val();
            $student = $("input[name=StudentID]").attr('value');
            $times = $("input[name=time]").val();
            $notes = $("input[name=notes]").val();

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('#mat_form').serialize(),
                success: function (res) {
                    $('input').val('');
                    $('.modal').modal('hide');
                    $('#example2').DataTable().ajax.reload( null, false );
                    
                    notif({
                        msg: "تم تعديل الرغبات بنجاح",
                        type: "success",
                    });
                },
                error: function (res) {
                    if(res.responseJSON.errors.StudentID){
                        $("form #errors-StudentID").css('display' , 'block').text(res.responseJSON.errors.StudentID);
                    }else{
                        $("form #errors-StudentID").text('');
                    }
                    if(res.responseJSON.errors.YearID){
                        $("form #errors-YearID").css('display' , 'block').text(res.responseJSON.errors.YearID);
                    }else{
                        $("form #errors-YearID").text('');
                    }
                }
            });
            
        });
    });
    
</script>