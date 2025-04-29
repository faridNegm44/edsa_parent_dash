<form id="mat_form">
    @csrf
    <input id="student_id" name="student_id" type="hidden" value="{{ $student['ID'] }}">

    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">  
                <div class="col-md-4">              
                    <div class="col-md-12">
                        <label for="YearID">الصفوف الدراسية</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend" style="width: 100%;">
                                <span class="input-group-text"><i class="fa fa-list"></i></span>
                                <select class="form-control" id="YearID" name="YearID" style="width: 100%;">
                                    <option value="">
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
                        <p class="errors" id="errors-YearID"></p>
                    </div>

                    <div class="col-xs-12">
                        {{-- <label class="label_mats" style="margin-bottom: 20px;font-size: 15px;">المواد الدراسيه طبقا للصف الدراسي</label> --}}
                        <table class="table table-striped table-bordered table1" id="table1" style="background: #FFF;width:93%;margin: 0px auto 30px;">
                            <thead>
                                <tr>
                                    <th>المواد</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>         
                
                <div class="col-md-8" id="TheMat">    
                    <div class="col-xs-12">
                        <label class="label_mats" style="font-size: 15px;">
                            رغبات الطالب
                            <span id="desires_count" style="color: red;font-size: 17px;margin: 0px 10px;">0</span>
                        </label>
                        <table class="table table-bordered table2 table-responsive" id="table2" style="background: #FFF;width: 100%;">
                            <thead>
                                <tr>
                                    <th>الماده</th>
                                    <th>الصف</th>
                                    <th>الفتره</th>
                                    <th>الباقة</th>
                                    <th style="width: 10%;">أكشن</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($student_desires as $item)
                                    <tr id="tr_{{ $item->YearID }}">
                                        <td class="first_td">
                                            <label for="{{ $item->mats_name['TheMat'] }}">{{ $item->mats_name['TheMat'] }}</label>
                                            <input class="form-control" type="hidden" id="{{ $item->YearID }}" value="{{ $item->YearID }}" name="new_matt[]" />
                                        </td>
                                        <td>
                                            <label for="" style="margin-top: 10px;">{{ $item->mats_name['TheYear'] }}</label>
                                            <input class="form-control" type="hidden" readonly id="" value="1" name="years[]" />
                                        </td>
                                        <td>
                                            <select class="form-control TheTime" id="TheTime" name="new_TheTime[]" style="width: 100%;">
                                                <option value="صباحا" {{ $item['TheTime'] == 'صباحا' ? 'selected' : null }}>
                                                    صباحا
                                                </option>
                                                <option value="مساءا" {{ $item['TheTime'] == 'مساءا' ? 'selected' : null }}>
                                                    مساءا
                                                </option>
                                            </select>
                                            
                                        </td>
                                        <td>
                                            <select class="form-control ThePackage" id="ThePackage" name="new_ThePackage[]" style="width: 100%;">
                                                <option value="باقة 1 طالب" {{ $item['ThePackage'] == 'باقة 1 طالب' ? 'selected' : null }}>
                                                    باقة 1 طالب
                                                </option>
                                                <option value="باقة 2 طالب" {{ $item['ThePackage'] == 'باقة 2 طالب' ? 'selected' : null }}>
                                                    باقة 2 طالب
                                                </option>
                                                <option value="باقة 3-6 طالب" {{ $item['ThePackage'] == 'باقة 3-6 طالب' ? 'selected' : null }}>
                                                    باقة 3-6 طالب
                                                </option>
                                                <option value="باقة التوفير" {{ $item['ThePackage'] == 'باقة التوفير' ? 'selected' : null }}>
                                                    باقة التوفير
                                                </option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <a id="{{ $item->YearID }}" student_id="{{ $student['ID'] }}" class="text-muted option-dots2 delete_desire" ><i class="fa fa-trash" style="color: #f35f5f;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="TheNotes">
                            <label for="TheNotes">ملاحظات</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend" style="width: 100%;">
                                    <span class="input-group-text"><i class="fa fa-pen"></i></span>
                                    <textarea class="form-control" rows="5" id="TheNotes" name="TheNotes" placeholder="ملاحظات">{{ $item['TheNotes'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" id="save">حفظ الرغبات</button>
                            <button class="btn ripple btn-default" data-dismiss="modal" type="button">خروج</button>
                        </div>
                    </div>                                                                                          
            </div>
        </div>
    </div>
</form>

    {{-- ///////////////////////// Add Row To Table 2 After Checked Matt /////////////////////////////  --}}
    @include('back.student.add_new_row_to_table_2')
    
    {{-- ///////////////////////// Return Row To Table 1 After Un Checked Matt /////////////////////////////  --}}
    @include('back.student.return_row_to_table_1')


    <script>
        $('.modal-title').html("رغبات");
        $(document).ready(function(){
            $(".select2_select2").select2({
                dropdownParent: $('#modaldemo8'),
            });

            var desires_count = $("#table2 tbody tr").length;
            $("#desires_count").text(desires_count);
        });
    </script>
    
    <script>
        $(document).on('hidden.bs.modal', '.modal', function (){ 

            location.reload();
        });
    </script>

    {{-- ///////////////////////// Change The Years /////////////////////////////  --}}
    <script>
        $(document).on('change', '#YearID', function(){
            let years_val = $(this).val();
            let student_id = $("#student_id").val();
            let act = "{{ url('dashboard/students/get_mat_after_change_years') }}"+"/"+years_val+"/"+student_id;

            $.ajax({
                type: "post",
                headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                url: act,
                data: $('#mat_form').serialize(),
                success: function (res) {
                    $("#table1 tbody tr").remove();
                    $("form #errors-YearID").text('');
                    
                    for(key in res){
                        $("#table1 tbody").append(`
                            <tr>
                                <td>
                                    <input class="matt_checkbox" type="checkbox" id="`+res[key].TheMat+`" value="`+res[key].ID+`" name="YearID[]" style="margin: 0px 7px;width:20px;height: 30px;position: relative;top: 10px;"/>
                                    <label for="`+res[key].TheMat+`">`+res[key].TheMat+`</label>
                                </td>
                            </tr>
                        `);
                    }      

                    notif({
                        msg: "تم استدعاء مواد المرحله",
                        type: "success",
                    });
                },
                error: function (res) {
                }
            });
        });
    </script>
    
    {{-- ///////////////////////// Save /////////////////////////////  --}}
    <script>
        $("#mat_form #save").click(function(e) {
                e.preventDefault();
                let act = "{{ url('dashboard/students/store_desires') }}";

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
                            msg: "تمت إضافه الرغبات بنجاح",
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
    </script>
