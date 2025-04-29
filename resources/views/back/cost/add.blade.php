<form>
    @csrf
    <div class="modal-body">
        <div class="pd-30 pd-sm-40 bg-gray-100">
            <div class="row row-xs">
                <div class="col-md-6">
                    <label for="ParentID">إسم ولي الأمر</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input class="form-control" disabled id="ParentID" name="ParentID" placeholder="إسم ولي الأمر" type="text" value="{{ auth()->user()->name }}" style="background: #FFF;">
                    </div>
                    <p class="errors" id="errors-ParentID"></p>
                </div>

                <div class="col-md-6">
                    <label for="TheName">إسم الطالب</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-child"></i></span>
                        </div>
                        <input class="form-control" id="TheName" name="TheName" placeholder="إسم الطالب" type="text" />
                    </div>
                    <p class="errors" id="errors-TheName"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="TheEmail">البريد الإلكتروني</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input class="form-control" id="TheEmail" name="TheEmail" placeholder="البريد الإلكتروني" type="text">
                    </div>
                    <p class="errors" id="errors-TheEmail"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="ThePhone">واتساب</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-mobile-alt" aria-hidden="true"></i></span>
                        </div>
                        <input class="form-control" id="ThePhone" name="ThePhone" placeholder="واتساب" type="text">
                    </div>
                    <p class="errors" id="errors-ThePhone"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="NatID">الجنسيه</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="width: 100%;">
                            <span class="input-group-text"><i class="fa fa-flag"></i></span>
                        <select class="form-control select2_select2" id="NatID" name="NatID" style="width: 100%;">
                            @foreach (\DB::table('tbl_nat')->get() as $item)
                                <option value="{{ $item->ID }}" @if ($item->ID == $parent['NatID']) selected @else '' @endif>
                                    {{ $item->TheName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <p class="errors" id="errors-NatID"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="CityID">مكان الإقامه</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="width: 100%;">
                            <span class="input-group-text"><i class="fa fa-city"></i></span>
                            <select class="form-control select2_select2" id="CityID" name="CityID" style="width: 100%;">
                                @foreach (\DB::table('tbl_cities')->get() as $item)
                                <option value="{{ $item->ID }}" @if ($item->ID == $parent['CityID']) selected @else '' @endif>
                                    دوله ( {{ $item->TheCountry }} ) --  مدينه ( {{ $item->TheCity }} )
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="errors" id="errors-CityID"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="TheEduType">نظام التعلم</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-book-reader"></i></span>
                        </div>
                        <select class="form-control" id="TheEduType" name="TheEduType">
                            <option value="عربي">
                                عربي
                            </option>
                            <option value="لغات">
                                لغات
                            </option>
                            <option value="أزهري">
                                أزهري
                            </option>
                            <option value="مناهج خليجيه">
                                مناهج خليجيه
                            </option>
                            <option value="International / American">
                                International / American
                            </option>
                            <option value="International / Britsh">
                                International / Britsh
                            </option>
                            <option value="International / SABIS">
                                International / SABIS
                            </option>
                            <option value="International / SAT">
                                International / SAT
                            </option>
                            <option value="International / IG">
                                International / IG
                            </option>
                            <option value="International / IB">
                                International / IB
                            </option>
                            <option value="غير ذلك">
                                غير ذلك
                            </option>
                        </select>
                    </div>
                    <p class="errors" id="errors-TheEduType"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="TheTestType">نظام الإختبارات</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-book-reader"></i></span>
                        </div>
                        <select class="form-control" id="TheTestType" name="TheTestType">
                            <option value="نظام التيرم في مصر">
                                نظام التيرم في مصر
                            </option>
                            <option value="نظام التيرم مسار مصري">
                                نظام التيرم مسار مصري
                            </option>
                            <option value="نظام اختبار السفاره تيرمين">
                                نظام اختبار السفاره تيرمين
                            </option>
                            <option value="نظام إختبار خليجي">
                                نظام إختبار خليجي
                            </option>
                            <option value="International Exam">
                                International Exam
                            </option>
                            <option value="غير ذلك">
                                غير ذلك
                            </option>
                        </select>
                    </div>
                    <p class="errors" id="errors-TheTestType"></p>
                </div>
                
                {{-- <div class="col-md-6">
                    <label for="TheStatus">حاله التسجيل</label>
                        <div class="input-group mb-3" style="background: #fff;border: 1px solid #e5e6f3;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="height: 39px;margin-left: 5px;"><i class="fa fa-check"></i></span>
                            </div>
                            <label for="1" style="margin: 10px 8px;">
                                <input type="radio" value="1" name="TheStatus" id="1"> <span>جديد</span>
                            </label>
                            <label for="2" style="margin: 10px 8px;">
                                <input type="radio" value="2" name="TheStatus" id="2"> <span>مفعل</span>
                            </label>
                            <label for="3" style="margin: 10px 8px;">
                                <input type="radio" value="3" name="TheStatus" id="3"> <span>غير مفعل</span>
                            </label>
                        </div>
                            
                    <p class="errors" id="errors-TheStatus"></p>
                </div> --}}
                
                <div class="col-md-6">
                    <label for="TheExplain">السجل الدراسي</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <textarea class="form-control" id="TheExplain" name="TheExplain" placeholder="السجل الدراسي" value="" rows="5" style="resize: none;"></textarea>
                    </div>
                    <p class="errors" id="errors-TheExplain"></p>
                </div>
                
                <div class="col-md-6">
                    <label for="TheNotes">ملاحظات</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <textarea class="form-control" name="TheNotes" id="TheNotes" placeholder="ملاحظات" value="" rows="5" style="resize: none;"></textarea>
                    </div>
                    <p class="errors" id="errors-TheNotes"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn ripple btn-primary" id="save">حفظ</button>
        <button class="btn ripple btn-default" data-dismiss="modal" type="button">إلغاء</button>
    </div>
</form>

<script>
    $('.modal-title').html("إضافه طالب");

    $(document).ready(function(){

        $(".select2_select2").select2({
            dropdownParent: $('.modal'),
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