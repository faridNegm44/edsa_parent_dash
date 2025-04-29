<form id="mat_form">
    @csrf

    {{-- <input id="ParentID" name="ParentID" placeholder="إسم ولي الأمر" type="hidden" value="{{ auth()->user()->name }}"> --}}
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
                    <label class="label_mats" style="margin-bottom: 20px;font-size: 15px;">المواد الدراسيه طبقا للصف الدراسي</label>
                    <div class="row">
                        @foreach ($get_all_mats_after_get_year as $item)
                            <div class="col-md-3 mats" style="margin: 10px 0px;font-size: 15px;">
                                <input type="checkbox" id="{{ $item->ID }}" name="TheMat[]" value="{{ $item->ID }}" style="width: 17px;height: 17px;"
                                @if (\App\Models\StudentsDesires::where('YearID', $item->ID)->first() )
                                    checked
                                @else
                                    
                                @endif
                                >
                                <label for="{{ $item->ID }}" style="margin: 0px 5px;top: -5px;position: relative;">
                                    {{ $item->TheMat }}
                                </label>
                            </div>     
                        @endforeach
                    </div>
                </div>                                                               
                                                                                                                
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-success" id="update">تعديل الرغبات</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">خروج</button>
    </div>
</form>

<script>
    $('.modal-title').html("تعديل رغبات");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
        });
        
        ///////////////////////// Change The Years ///////////////////////////// 
        $("#YearID").change(function(){
           let years_val = $(this).val();
           let act = "{{ url('dashboard/students/get_mat_after_change_years') }}"+"/"+years_val;

            $.ajax({
                type: "get",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('#mat_form').serialize(),
                success: function (res) {
                    $("#TheMat .row .mats").remove();
                    $("#TheMat .label_mats").css('display', 'block');
                    $("form #errors-YearID").text('');

                    console.log(res)
                    for(key in res){
                        $("#TheMat .row").append(`
                            <div class="col-md-3 mats" style="margin: 10px 0px;font-size: 15px;">
                                <input type="checkbox" id="`+res[key].TheMat+`" name="TheMat[]" value="`+res[key].ID+`" style="width: 17px;height: 17px;">
                                <label for="`+res[key].TheMat+`" style="margin: 0px 5px;top: -5px;position: relative;">
                                    `+res[key].TheMat+`
                                </label>
                            </div>  
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